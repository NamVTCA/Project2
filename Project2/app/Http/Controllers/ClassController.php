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
            // Cập nhật thông tin lớp học (tên lớp, giáo viên, trạng thái)
            $classroom->update($data);

            // Lấy tất cả facility hiện có của lớp
            $currentFacilities = $classroom->facilities()->get();
            $currentFacilityIds = $currentFacilities->pluck('id')->toArray();

            // Lấy danh sách facility gửi lên
            $facilityDetails = $request->input('facility_details', []);

            // Mảng lưu ID facility vẫn còn sau khi update (cũ giữ lại hoặc mới thêm)
            $existingFacilityIds = [];

            // Trước tiên, ta sẽ xử lý logic thêm mới facility và giữ facility cũ
            foreach ($facilityDetails as $index => $detail) {
                if (isset($detail['id'])) {
                    // Đây là facility cũ. User không thay đổi số lượng hay trạng thái, nên chỉ giữ nguyên
                    $facility = facilities::find($detail['id']);
                    if ($facility) {
                        // Đánh dấu facility này vẫn tồn tại (không xóa)
                        $existingFacilityIds[] = $facility->id;
                    }
                } else {
                    // Đây là facility mới thêm
                    $dentailId = $detail['dentail_id'] ?? null;
                    $addQuantity = $detail['quantity'] ?? 0;

                    if (!$dentailId || $addQuantity <= 0) {
                        // Nếu thiếu thông tin cần thiết, rollback
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Thiếu thông tin cơ sở vật chất mới']);
                    }

                    $dentailFacility = dentail_fatilities::find($dentailId);
                    if (!$dentailFacility) {
                        // dentail_id không tồn tại
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Cơ sở vật chất không tồn tại']);
                    }

                    // Kiểm tra số lượng dentail_facilities có đủ không
                    if ($dentailFacility->quantity < $addQuantity) {
                        // Không đủ số lượng để thêm
                        DB::rollBack();
                        return redirect()->back()->withErrors(['error' => 'Số lượng cơ sở vật chất không đủ']);
                    }

                    // Trừ số lượng từ dentail_facilities
                    $dentailFacility->decrement('quantity', $addQuantity);

                    // Tạo facility mới trong lớp
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

            // Xử lý xóa những facility cũ không còn trong request:
            // Nếu facility cũ không xuất hiện trong $existingFacilityIds, nghĩa là user đã xóa nó
            $facilitiesToDelete = $classroom->facilities()
                ->whereNotIn('id', $existingFacilityIds)
                ->get();

            foreach ($facilitiesToDelete as $facility) {
                $dentailFacility = dentail_fatilities::find($facility->dentail_id);
                if ($dentailFacility) {
                    // Cộng lại số lượng
                    $dentailFacility->increment('quantity', $facility->quantity);
                }
                // Xóa facility khỏi lớp
                $facility->delete();
            }

            DB::commit();
            return redirect()->route('admin.classrooms.index')
                ->with('success', 'Cập nhật lớp học thành công.');
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
