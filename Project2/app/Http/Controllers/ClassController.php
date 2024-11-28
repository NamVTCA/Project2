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
        $teachers = User::where('role', 1)->get();
        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(ClassRequest $request)
    {
        $data = $request->validated();
        
        // Tạo lớp học
        $classroom = Classroom::create($data);
        
        // Thêm cơ sở vật chất
        if ($request->has('facility_details')) {
            foreach ($request->input('facility_details') as $facilityDetail) {
                facilities::create([
                    'name' => $facilityDetail['name'],
                    'status' => $facilityDetail['status'],
                    'quantity' => $facilityDetail['quantity'],
                    'classroom_id' => $classroom->id, // Sử dụng 'classroom_id' thay vì 'class_id'
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
        $teachers = User::where('role', 1)->get();
        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(ClassRequest $request, Classroom $classroom)
    {
        $data = $request->validated();
        
        // Cập nhật thông tin lớp học
        $classroom->update($data);

        // Cập nhật cơ sở vật chất
        if ($request->has('facility_details')) {
            $classroom->facilities()->delete(); // Xóa cơ sở vật chất cũ
            foreach ($request->input('facility_details') as $facilityDetail) {
                facilities::create([
                    'name' => $facilityDetail['name'],
                    'status' => $facilityDetail['status'],
                    'quantity' => $facilityDetail['quantity'],
                    'classroom_id' => $classroom->id, 
                ]);
            }
        }
        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật thành công.');
    }
}

?>