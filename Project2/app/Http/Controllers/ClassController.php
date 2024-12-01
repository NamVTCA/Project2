<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use App\Models\facilities;
use App\Http\Requests\ClassRequest;
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

        return view('admin.classrooms.edit', compact('classroom', 'teachers', 'allTeachers'));
    }

    public function update(ClassRequest $request, Classroom $classroom)
    {
        $data = $request->validated();
        
        $classroom->update($data);

        if ($request->has('facility_details')) {
            $existingFacilityIds = [];

            foreach ($request->input('facility_details') as $facilityDetail) {
                if (isset($facilityDetail['id'])) {
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
                    $newFacility = $classroom->facilities()->create([
                        'name' => $facilityDetail['name'],
                        'status' => $facilityDetail['status'],
                        'quantity' => $facilityDetail['quantity'],
                    ]);
                    $existingFacilityIds[] = $newFacility->id;
                }
            }

            // Delete facilities that are no longer in the request
            facilities::where('classroom_id', $classroom->id)
                ->whereNotIn('id', $existingFacilityIds)
                ->delete();
        }

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật thành công.');
    }
}

?>