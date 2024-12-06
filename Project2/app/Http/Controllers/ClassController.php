<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
                    // Giảm số lượng từ bảng dentail_fatilities
                    $dentailFacility->decrement('quantity', $facilityDetail['quantity']);
                    
                    // Tạo bản ghi mới trong bảng facilities
                    $classroom->facilities()->create([
                        'name' => $dentailFacility->name, // Ghi tên cơ sở vật chất từ dentail
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
        
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // Cập nhật thông tin cơ bản của lớp học
            $classroom->update($data);

            // Lấy danh sách facility cũ trong lớp
            $currentFacilities = $classroom->facilities()->get();
            $currentFacilityIds = $currentFacilities->pluck('id')->toArray();

            // Danh sách facility gửi lên
            $facilityDetails = $request->input('facility_details', []);

            // Mảng lưu facility ID sau khi xử lý (giữ nguyên hoặc thêm mới)
            $existingFacilityIds = [];

            // Xử lý facility cũ: 
            // Facility cũ sẽ xuất hiện trong request với 'id'
            foreach ($facilityDetails as $detail) {
                if (isset($detail['id'])) {
                    // Facility này là facility cũ, user giữ nguyên
                    $existingFacilityIds[] = $detail['id'];
                    // Không được phép thay đổi số lượng, status
                    // Không làm gì ở đây, chỉ đánh dấu là còn tồn tại
                } else {
                    // Đây là facility mới thêm
                    $dentailId = $detail['dentail_id'] ?? null;
                    $addQuantity = $detail['quantity'] ?? 0;

                    $dentailFacility = dentail_fatilities::find($dentailId);
                    if (!$dentailFacility) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Cơ sở vật chất không tồn tại.']);
                    }

                    if ($dentailFacility->quantity < $addQuantity) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Số lượng không đủ để thêm.']);
                    }

                    // Trừ đi số lượng từ dentail_facilities
                    $dentailFacility->decrement('quantity', $addQuantity);

                    // Tạo mới facility trong lớp
                    $newFacility = $classroom->facilities()->create([
                        'name' => $dentailFacility->name,
                        'quantity' => $addQuantity,
                        'classroom_id' => $classroom->id,
                        'dentail_id' => $dentailFacility->id,
                        'status' => $dentailFacility->status,
                    ]);

                    $existingFacilityIds[] = $newFacility->id;
                }
            }

            // Xóa những facility cũ mà không còn trong request => người dùng xóa chúng
            $facilitiesToDelete = $classroom->facilities()
                ->whereNotIn('id', $existingFacilityIds)
                ->get();
            
            foreach ($facilitiesToDelete as $facility) {
                $dentailFacility = dentail_fatilities::find($facility->dentail_id);
                if ($dentailFacility) {
                    // Cộng lại số lượng vào dentail_facilities
                    $dentailFacility->increment('quantity', $facility->quantity);
                }
                // Xóa facility khỏi lớp
                $facility->delete();
            }

            DB::commit();
            return redirect()->route('admin.classrooms.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyFacility($id)
    {
        $facility = facilities::findOrFail($id);
        $dentailFacility = dentail_fatilities::find($facility->dentail_id);
        if ($dentailFacility) {
            $dentailFacility->increment('quantity', $facility->quantity);
        }
        $facility->delete();

        return response()->json(['success' => 'Cơ sở vật chất đã được xóa thành công.']);
    }

}

?>
