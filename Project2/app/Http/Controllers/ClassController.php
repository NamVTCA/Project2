<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
        $classrooms = Classroom::with(['user', 'facilities'])->get(); // Thêm 'facilities' vào với
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = User::where('role', 1)
            ->whereDoesntHave('classroom')
            ->get();

        $allTeachers = User::where('role', 1)->get(); 
        $totalFacilities = total_facilities::all(); // Lấy danh sách total_fatilities

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
        $totalFacilities = total_facilities::with('dentail')->get(); // Lấy danh sách total_fatilities và dentail

        return view('admin.classrooms.edit', compact('classroom', 'teachers', 'allTeachers', 'facilities', 'totalFacilities'));
    }

    public function update(ClassRequest $request, Classroom $classroom)
{
    $data = $request->validated();
    DB::beginTransaction();
    try {
        // Cập nhật thông tin lớp
        $classroom->update($data);

        // Lấy danh sách facility bị xóa (ID từ input hidden)
        $deletedFacilitiesIds = $request->input('deleted_facilities', '');
        $deletedIds = $deletedFacilitiesIds ? explode(',', $deletedFacilitiesIds) : [];

        // Xử lý xóa facility qua API
        foreach ($deletedIds as $facilityId) {
            $facility = DB::table('facilities')->where('id', $facilityId)->first();
            if ($facility) {
                // Giả sử bạn lưu 'name' của dentail_facility trong cột 'name' của facilities
                $facilityName = $facility->name;
                $facilityQuantity = $facility->quantity;

                // Gọi API để tăng số lượng dentail_facilities dựa trên 'name'
                // Giả sử bạn có một endpoint: POST /api/dentail_facilities/increment
                // Gửi dữ liệu 'name' và 'quantity' để API xử lý tăng số lượng
                $response = Http::post(url('/api/dentail_facilities/increment'), [
                    'name' => $facilityName,
                    'quantity' => $facilityQuantity,
                ]);

                if ($response->failed()) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Không thể hoàn lại số lượng cơ sở vật chất (API lỗi).']);
                }

                // Xóa facility khỏi bảng facilities
                DB::table('facilities')->where('id', $facilityId)->delete();
            }
        }

        // Xử lý facility cũ (giữ nguyên) và facility mới (thêm)
        $facilityDetails = $request->input('facility_details', []);
        $existingFacilityIds = [];

        foreach ($facilityDetails as $detail) {
            if (isset($detail['id'])) {
                // Facility cũ được giữ nguyên, không làm gì thêm
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

                // Gọi API để lấy thông tin dentail_facility
                // Giả sử có endpoint: GET /api/dentail_facilities/{dentailId}
                $dentailResponse = Http::get(url('/api/dentail_facilities/' . $dentailId));
                if ($dentailResponse->failed()) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Không thể lấy thông tin dentail_facility từ API']);
                }

                $dentailFacility = $dentailResponse->json();
                // $dentailFacility bây giờ là array chứa name, quantity, status, ...
                
                if ($dentailFacility['quantity'] < $addQuantity) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Số lượng cơ sở vật chất không đủ']);
                }

                // Gọi API để decrement số lượng dentail_facilities
                $decrementResponse = Http::post(url('/api/dentail_facilities/decrement'), [
                    'id' => $dentailId,
                    'quantity' => $addQuantity,
                ]);
                if ($decrementResponse->failed()) {
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Không thể trừ số lượng cơ sở vật chất (API lỗi).']);
                }

                // Tạo facility mới trong lớp (dùng DB query builder hoặc Eloquent)
                // Lưu lại name chính là name từ dentail_facility để sau này khi xóa dễ tìm
                $newFacilityId = DB::table('facilities')->insertGetId([
                    'name' => $dentailFacility['name'],
                    'quantity' => $addQuantity,
                    'classroom_id' => $classroom->id,
                    'status' => $dentailFacility['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $existingFacilityIds[] = $newFacilityId;
            }
        }

        // Không cần whereNotIn vì đã xử lý xóa bằng deleted_facilities
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

?>
