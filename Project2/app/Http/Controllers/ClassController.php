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
        
        // Tạo lớp học mới
        $classroom = Classroom::create($data);

        // Thêm cơ sở vật chất vào lớp học
        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                // Lấy thông tin từ dentail_fatilities
                $dentailFacility = dentail_fatilities::find($facilityDetail['dentail_id']);
                
                if ($dentailFacility) {
                    // Tạo bản ghi mới trong bảng facilities, chỉ lưu trữ thông tin liên quan đến lớp học và cơ sở vật chất
                    $classroom->facilities()->create([
                        'name' => $dentailFacility->name, // Sử dụng tên từ dentail_fatilities
                        'quantity' => $facilityDetail['quantity'],
                        'classroom_id' => $classroom->id,
                        'total_id' => $facilityDetail['total_id'],
                        'dentail_id' => $facilityDetail['dentail_id'],
                        'status' => $dentailFacility->status,
                    ]);
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

        // Lấy danh sách ID của cơ sở vật chất cũ để kiểm tra và xóa
        $existingFacilityIds = $classroom->facilities->pluck('id')->toArray();

        // Lưu trữ danh sách các ID cơ sở vật chất mới hoặc cập nhật
        $newFacilityIds = [];

        // Cập nhật hoặc thêm mới cơ sở vật chất
        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                if (isset($facilityDetail['id'])) {
                    // Cập nhật cơ sở vật chất đã tồn tại
                    $facility = facilities::find($facilityDetail['id']);
                    if ($facility) {
                        $facility->update([
                            'quantity' => $facilityDetail['quantity'],
                        ]);
                        $newFacilityIds[] = $facility->id;
                    }
                } else {
                    // Thêm mới cơ sở vật chất vào lớp học
                    $dentailFacility = dentail_fatilities::find($facilityDetail['dentail_id']);
                    
                    if ($dentailFacility) {
                        $newFacility = $classroom->facilities()->create([
                            'name' => $dentailFacility->name,
                            'quantity' => $facilityDetail['quantity'],
                            'classroom_id' => $classroom->id,
                            'total_id' => $facilityDetail['total_id'],
                            'dentail_id' => $facilityDetail['dentail_id'],
                            'status' => $dentailFacility->status,
                        ]);
                        $newFacilityIds[] = $newFacility->id;
                    }
                }
            }
        }

        // Xóa các cơ sở vật chất cũ không còn nằm trong danh sách mới
        $facilitiesToDelete = array_diff($existingFacilityIds, $newFacilityIds);
        facilities::whereIn('id', $facilitiesToDelete)->delete();

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
