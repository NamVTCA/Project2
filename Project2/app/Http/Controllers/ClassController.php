<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
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
    { $teachers = User::where('role', 1)->get();
        return view('admin.classrooms.create',compact('teachers'));
    }
    public function store(ClassRequest $request)
    {
        Classroom::create($request->validated());

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Lớp học đã được tạo thành công.');
    }
    public function show(Classroom $classroom)
    {
        return view('admin.classrooms.show', compact('classrooms'));
    }
    public function edit(Classroom $classroom)
    {
        $teachers = User::where('role', 1)->get();
        return view('admin.classrooms.edit', compact('classrooms', 'teachers'));
    }
    public function update(ClassRequest $request, Classroom $classroom)
    {
        $classroom->update($request->validated());

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật thành công.');
    }
}

?>