<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Http\Requests\ClassRequest;
use App\Models\facilities;
use App\Models\total_facilities;
use App\Models\dentail_facilities;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with(['user', 'facilities'])->get(); 
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = User::where('role', 1)
            ->whereDoesntHave('classroom')
            ->get();

        $allTeachers = User::where('role', 1)->get(); 
        $totalFacilities = total_facilities::all(); 

        return view('admin.classrooms.create', compact('teachers', 'allTeachers', 'totalFacilities'));
    }

    public function store(ClassRequest $request)
    {
        $data = $request->validated();
        
        $classroom = Classroom::create($data);

        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                $dentailFacility = dentail_facilities::find($facilityDetail['dentail_id']);
                
                if ($dentailFacility && $dentailFacility->quantity >= $facilityDetail['quantity']) {
                    // Trừ số lượng trực tiếp
                    $dentailFacility->decrement('quantity', $facilityDetail['quantity']);
                    
                    // Tạo facility mới
                    $classroom->facilities()->create([
                        'name' => $dentailFacility->name,
                        'quantity' => $facilityDetail['quantity'],
                        'classroom_id' => $classroom->id,
                        'dentail_id' => $facilityDetail['dentail_id'],
                        'status' => $dentailFacility->status,
                    ]);
                } else {
                    return redirect()->back()->withErrors(['facility' => 'Số lượng không đủ để thêm cơ sở vật chất này']);
                }
            }
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Lớp học đã được tạo thành công.');
    }

    // Giữ nguyên nếu bạn cần API này cho frontend load data
    public function getDentailFacilities($totalId)
    {
        $dentailFacilities = dentail_facilities::where('total_id', $totalId)->get();
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
        $totalFacilities = total_facilities::with('dentail')->get();

        return view('admin.classrooms.edit', compact('classroom', 'teachers', 'allTeachers', 'facilities', 'totalFacilities'));
    }

    public function update(ClassRequest $request, Classroom $classroom)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $classroom->update($data);

            $deletedFacilitiesIds = $request->input('deleted_facilities', '');
            $deletedIds = $deletedFacilitiesIds ? explode(',', $deletedFacilitiesIds) : [];

            // Xóa facility cũ: cộng lại số lượng vào dentail_facilities
            foreach ($deletedIds as $facilityId) {
                $facility = DB::table('facilities')->where('id', $facilityId)->first();
                if ($facility) {
                    $facilityName = $facility->name;
                    $facilityQuantity = $facility->quantity;

                    // Tìm dentail_facility theo name
                    $dentail = dentail_facilities::where('name', $facilityName)->first();
                    if (!$dentail) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Dentail facility not found']);
                    }

                    // Cộng lại số lượng
                    $dentail->increment('quantity', $facilityQuantity);

                    // Xóa facility
                    DB::table('facilities')->where('id', $facilityId)->delete();
                }
            }

            // Xử lý facility cũ (giữ nguyên) và mới (thêm)
            $facilityDetails = $request->input('facility_details', []);
            $existingFacilityIds = [];

            foreach ($facilityDetails as $detail) {
                if (isset($detail['id'])) {
                    // Facility cũ giữ nguyên
                    $facilityId = $detail['id'];
                    $exists = DB::table('facilities')->where('id', $facilityId)->exists();
                    if ($exists) {
                        $existingFacilityIds[] = $facilityId;
                    }
                } else {
                    // Thêm mới facility
                    $dentailId = $detail['dentail_id'] ?? null;
                    $addQuantity = $detail['quantity'] ?? 0;
                    $totalId = $detail['total_id'] ?? null;

                    if (!$dentailId || $addQuantity <= 0 || !$totalId) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Thiếu thông tin cơ sở vật chất mới']);
                    }

                    // Lấy thông tin dentail_facility trực tiếp
                    $dentailFacility = dentail_facilities::find($dentailId);
                    if (!$dentailFacility) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Cơ sở vật chất không tồn tại']);
                    }

                    if ($dentailFacility->quantity < $addQuantity) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Số lượng cơ sở vật chất không đủ']);
                    }

                    // Trừ số lượng
                    $dentailFacility->decrement('quantity', $addQuantity);

                    // Tạo facility mới
                    $newFacilityId = DB::table('facilities')->insertGetId([
                        'name' => $dentailFacility->name,
                        'quantity' => $addQuantity,
                        'classroom_id' => $classroom->id,
                        'status' => $dentailFacility->status,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $existingFacilityIds[] = $newFacilityId;
                }
            }

            DB::commit();
            return redirect()->route('admin.classrooms.index')->with('success', 'Cập nhật lớp học thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyFacility($id)
    {
        DB::beginTransaction();
        try {
            $facility = facilities::findOrFail($id);

            $dentailFacility = dentail_facilities::find($facility->dentail_id);

            if ($dentailFacility) {
                // Cộng lại số lượng trực tiếp
                $dentailFacility->increment('quantity', $facility->quantity);
            }

            $facility->delete();

            DB::commit();
            return response()->json(['success' => 'Cơ sở vật chất đã được xóa thành công.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }
}
