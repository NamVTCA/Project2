<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChildController extends Controller
{
    public function index()
    {
        $children = Child::with('user')->get();
        return view('admin.children.index', compact('children'));
    }

    public function create()
    {
        $users = User::all();
        //$classrooms = Classroom::all();
        return view('admin.children.create', compact('users', /*'classrooms'*/));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'birthyear' => 'required|date',
            'gender' => 'required|string|max:10',
            'user_id' => 'required|exists:users,id', 
        ]);

        Child::create($request->all());

        return redirect()->route('children.index')->with('success', 'Child created successfully.');
    }

    public function show(Child $child)
    {
        $child->load('user'); 
        return view('admin.children.show', compact('child'));
    }

    public function edit(Child $child)
    {
        $parents = User::where('role', 2)->get();
        return view('admin.children.edit', compact('child', 'parents'));
    }

    public function update(Request $request, Child $child)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'birthyear' => 'required|date',
            'gender' => 'required|string|max:10',
            'user_id' => 'required|exists:users,id',
        ]);

        $child->update($request->all());

        return redirect()->route('children.index')->with('success', 'Child updated successfully.');
    }
}
