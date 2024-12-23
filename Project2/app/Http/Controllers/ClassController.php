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
        $totalFacilities = total_facilities::with('dentail')->get(); 

        return view('admin.classrooms.create', compact('teachers', 'allTeachers', 'totalFacilities'));
    }

    public function store(ClassRequest $request)
    {
        $data = $request->validated();

        $classroom = Classroom::create($data);

        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $dentailId => $facilityDetail) {
                $dentailFacility = dentail_facilities::find($dentailId);

                if ($dentailFacility) {
                    // Trừ số lượng trực tiếp
                    $dentailFacility->decrement('quantity', $facilityDetail['quantity']);

                    // Tạo facility mới
                    $classroom->facilities()->create([
                        'name' => $dentailFacility->name,
                        'quantity' => $facilityDetail['quantity'],
                        'classroom_id' => $classroom->id,
                        'dentail_id' => $dentailId, // Lưu dentail_id
                        'status' => $dentailFacility->status,
                    ]);
                } else {
                    return redirect()->back()->withErrors(['facility' => 'Cơ sở vật chất không tồn tại']);
                }
            }
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Lớp học đã được tạo thành công.');
    }

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
        // Lấy danh sách giáo viên
        $teachers = User::where('role', 1)
            ->whereDoesntHave('classroom', function ($query) use ($classroom) {
                $query->where('id', '!=', $classroom->id);
            })
            ->orWhere('id', $classroom->user_id)
            ->get();

        // Lấy tất cả giáo viên
        $allTeachers = User::where('role', 1)->get();

        // Lấy danh sách facilities của lớp học
        $facilities = $classroom->facilities()->with('dentail')->get(); 

        // Lấy danh sách các total facilities cùng với các chi tiết của chúng
        $totalFacilities = total_facilities::with('dentail')->get(); // Lấy total_facilities cùng với chi tiết dentail

        // Trả về view cùng với tất cả các dữ liệu cần thiết
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
                $facility = facilities::find($facilityId);
                if ($facility) {
                    $dentailFacility = dentail_facilities::find($facility->dentail_id);
                    if (!$dentailFacility) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Cơ sở vật chất không tồn tại']);
                    }
                    $dentailFacility->increment('quantity', $facility->quantity);
                    $facility->delete();
                }
            }

            // Xử lý facility cũ (cập nhật số lượng) và mới (thêm)
            $facilityDetails = $request->input('facility_details', []);
            $oldFacilityDetails = $request->input('facility_details_old', []);

            // Cập nhật số lượng cho các facility cũ
            if (is_array($oldFacilityDetails)) {
                foreach ($oldFacilityDetails as $dentailId => $detail) {
                    $facility = facilities::where('classroom_id', $classroom->id)
                                        ->where('dentail_id', $dentailId)
                                        ->first();
                    if ($facility) {
                        $dentailFacility = dentail_facilities::find($dentailId);
                        // Lấy số lượng hiện tại từ bảng facilities
                        $currentQuantityInFacility = $facility->quantity;

                        // Tính toán sự thay đổi số lượng
                        $quantityChange = $detail['quantity'] - $currentQuantityInFacility;

                        // Cập nhật số lượng mới cho facility
                        $facility->update([
                            'quantity' => $detail['quantity'],
                        ]);

                        // Nếu có sự thay đổi số lượng, cập nhật dentail_facilities
                        if ($quantityChange != 0) {
                            $dentailFacility->decrement('quantity', $quantityChange);
                        }
                    }
                }
            }

            // Thêm mới facility
            if (is_array($facilityDetails)) {
                foreach ($facilityDetails as $dentailId => $detail) {
                    $dentailFacility = dentail_facilities::find($dentailId);
                    if (!$dentailFacility) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Cơ sở vật chất không tồn tại']);
                    }

                    if ($dentailFacility->quantity < $detail['quantity']) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Số lượng cơ sở vật chất không đủ']);
                    }

                    $dentailFacility->decrement('quantity', $detail['quantity']);
                    $classroom->facilities()->create([
                        'name' => $dentailFacility->name,
                        'quantity' => $detail['quantity'],
                        'dentail_id' => $dentailFacility->id,
                        'status' => $dentailFacility->status,
                    ]);
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