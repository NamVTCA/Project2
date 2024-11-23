<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index()
    {
        $children = Child::with(['user', 'classroom'])->get();
        $childrenData = $children->map(function ($child) {
            return [
                'id' => $child->id,
                'name' => $child->name,
                'parent_name' => $child->user->name,
                'classroom_name' => $child->classroom->name ?? 'Chưa được phân lớp',
                'birthdate' => \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y'),
                'gender' => $child->gender == 1 ? 'Nam' : 'Nữ',
                'img' => $child->img,
            ];
        });

        return view('admin.children.index', compact('childrenData'));
    }


    public function create()
    {
        $parents = User::where('role', 2)->get(); 
        return view('admin.children.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'birthDate' => 'required|date',
            'gender' => 'required|in:1,2',
            'img' => 'nullable|image|max:2048',
        ]);

        $child = Child::create($validatedData);

        if ($request->hasFile('img')) {
            $child->img = $request->file('img')->store('children', 'public');
            $child->save();
        }

        return redirect()->route('admin.children.index')->with('success', 'Trẻ em đã được thêm thành công.');
    }

    public function show(Child $child)
    {
        $parent = $child->user;
        return view('admin.children.show', compact('child', 'parent'));
    }

    public function edit(Child $child)
    {
        $parents = User::where('role', 2)->get();
        return view('admin.children.edit', compact('child', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $child = Child::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'birthDate' => 'required|date',
            'gender' => 'required|in:1,2', // 1: Nam, 2: Nữ
            'img' => 'nullable|image|max:2048',
        ]);

        $child->update($validatedData);

        if ($request->hasFile('img')) {
            $child->img = $request->file('img')->store('children', 'public');
            $child->save();
        }

        return redirect()->route('children.index')->with('success', 'Thông tin trẻ em đã được cập nhật.');
    }
}