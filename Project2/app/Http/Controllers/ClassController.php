<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Facility;
use App\Http\Requests\ClassRequest;
use App\Models\facilities;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('user')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = User::where('role', 1) 
        ->whereDoesntHave('classroom')
        ->get();

        $allTeachers = User::where('role', 1)->get(); 

        return view('admin.classrooms.create', compact('teachers', 'allTeachers'));
    }

    public function store(ClassRequest $request)
    {
        $data = $request->validated();
        
        $classroom = Classroom::create($data);
        
        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                facilities::create([
                    'name' => $facilityDetail['name'],
                    'status' => isset($facilityDetail['status']) ? $facilityDetail['status'] : 1,
                    'quantity' => $facilityDetail['quantity'],
                    'classroom_id' => $classroom->id,
                ]);
            }
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Lớp học đã được tạo thành công.');
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

        return view('admin.classrooms.edit', compact('classroom', 'teachers', 'allTeachers', 'facilities'));
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
                        $facility->update([
                            'name' => $facilityDetail['name'],
                            'status' => $facilityDetail['status'],
                            'quantity' => $facilityDetail['quantity'],
                        ]);
                        $existingFacilityIds[] = $facility->id;
                    }
                } else {
                    // Thêm mới cơ sở vật chất
                    $newFacility = $classroom->facilities()->create([
                        'name' => $facilityDetail['name'],
                        'status' => $facilityDetail['status'],
                        'quantity' => $facilityDetail['quantity'],
                    ]);
                    $existingFacilityIds[] = $newFacility->id;
                }
            }
        }

        if ($request->has('deleted_facilities')) {
            $deletedFacilityIds = explode(',', $request->input('deleted_facilities'));
            facilities::whereIn('id', $deletedFacilityIds)->delete();
        }
        // Xóa cơ sở vật chất không còn trong yêu cầu
        facilities::where('classroom_id', $classroom->id)
            ->whereNotIn('id', $existingFacilityIds)
            ->delete();

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật thành công.');
    }


    public function destroyFacility($id)
    {
        $facility = facilities::findOrFail($id);
        $facility->delete();

        return response()->json(['success' => 'Cơ sở vật chất đã được xóa thành công.']);
    }
}

?>
