<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Http\Requests\ClassRequest;
use App\Models\facilities;
use App\Models\total_fatilities;
use App\Models\dentail_fatilities;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with(['user', 'facilities'])->get(); // Thêm 'facilities' vào với
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = User::where('role', 1)
            ->whereDoesntHave('classroom')
            ->get();

        $allTeachers = User::where('role', 1)->get(); 
        $totalFacilities = total_fatilities::all(); // Lấy danh sách total_fatilities

        return view('admin.classrooms.create', compact('teachers', 'allTeachers', 'totalFacilities'));
    }

    public function store(ClassRequest $request)
    {
        $data = $request->validated();
        
        $classroom = Classroom::create($data);

        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                $dentailFacility = dentail_fatilities::find($facilityDetail['dentail_id']);
                
                if ($dentailFacility && $dentailFacility->quantity >= $facilityDetail['quantity']) {
                    // Cập nhật số lượng còn lại trong dentail_fatilities
                    $dentailFacility->decrement('quantity', $facilityDetail['quantity']);
                    $classroom->facilities()->create([
                        'total_id' => $facilityDetail['total_id'],
                        'dentail_id' => $facilityDetail['dentail_id'],
                        'quantity' => $facilityDetail['quantity'],
                    ]);
                } else {
                    return redirect()->back()->withErrors(['facility' => 'Số lượng không đủ để thêm cơ sở vật chất này']);
                }
            }
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Lớp học đã được tạo thành công.');
    }

    // API để lấy danh sách dentail facilities
    public function getDentailFacilities($totalId)
    {
        $dentailFacilities = dentail_fatilities::where('total_id', $totalId)->get();
        return response()->json($dentailFacilities);
    }

    public function show(Classroom $classroom)
    {
        return view('admin.classrooms.show', compact('classroom'));
    }

    public function edit(Classroom $classroom)
    {
        $teachers = User::where('role', 1)
            ->whereDoesntHave('classroom', function ($query) use ($classroom) {
                $query->where('id', '!=', $classroom->id);
            })
            ->orWhere('id', $classroom->user_id)
            ->get();

        $allTeachers = User::where('role', 1)->get();
        $facilities = $classroom->facilities;
        $totalFacilities = total_fatilities::with('dentail')->get(); // Lấy danh sách total_fatilities và dentail

        return view('admin.classrooms.edit', compact('classroom', 'teachers', 'allTeachers', 'facilities', 'totalFacilities'));
    }

    public function update(ClassRequest $request, Classroom $classroom)
    {
        $data = $request->validated();

        // Cập nhật thông tin lớp học
        $classroom->update($data);

        // Cập nhật hoặc xóa cơ sở vật chất
        $existingFacilityIds = [];

        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                if (isset($facilityDetail['id'])) {
                    // Tìm và cập nhật cơ sở vật chất đã tồn tại
                    $facility = facilities::find($facilityDetail['id']);
                    if ($facility) {
                        $dentailFacility = dentail_fatilities::find($facility->dentail_id);
                        if ($dentailFacility) {
                            // Cập nhật số lượng cơ sở vật chất
                            $quantityDiff = $facilityDetail['quantity'] - $facility->quantity;
                            if ($dentailFacility->quantity >= $quantityDiff) {
                                $dentailFacility->decrement('quantity', $quantityDiff);
                                $facility->update([
                                    'total_id' => $facilityDetail['total_id'],
                                    'quantity' => $facilityDetail['quantity'],
                                ]);
                            } else {
                                return redirect()->back()->withErrors(['facility' => 'Số lượng không đủ để cập nhật cơ sở vật chất này']);
                            }
                        }
                        $existingFacilityIds[] = $facility->id;
                    }
                } else {
                    // Thêm mới cơ sở vật chất
                    $dentailFacility = dentail_fatilities::find($facilityDetail['dentail_id']);
                    if ($dentailFacility && $dentailFacility->quantity >= $facilityDetail['quantity']) {
                        $dentailFacility->decrement('quantity', $facilityDetail['quantity']);
                        $newFacility = $classroom->facilities()->create([
                            'total_id' => $facilityDetail['total_id'],
                            'dentail_id' => $facilityDetail['dentail_id'],
                            'quantity' => $facilityDetail['quantity'],
                        ]);
                        $existingFacilityIds[] = $newFacility->id;
                    } else {
                        return redirect()->back()->withErrors(['facility' => 'Số lượng không đủ để thêm cơ sở vật chất này']);
                    }
                }
            }
        }

        if ($request->has('deleted_facilities')) {
            $deletedFacilityIds = explode(',', $request->input('deleted_facilities'));
            foreach ($deletedFacilityIds as $facilityId) {
                $facility = facilities::find($facilityId);
                if ($facility) {
                    $dentailFacility = dentail_fatilities::find($facility->dentail_id);
                    if ($dentailFacility) {
                        // Hoàn trả số lượng về dentail_fatilities khi xóa
                        $dentailFacility->increment('quantity', $facility->quantity);
                    }
                    $facility->delete();
                }
            }
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật thành công.');
    }

    public function destroyFacility($id)
    {
        $facility = facilities::findOrFail($id);
        $dentailFacility = dentail_fatilities::find($facility->dentail_id);
        if ($dentailFacility) {
            // Trả lại số lượng cho dentail facility khi xóa
            $dentailFacility->increment('quantity', $facility->quantity);
        }
        $facility->delete();

        return response()->json(['success' => 'Cơ sở vật chất đã được xóa thành công.']);
    }

}

?>
