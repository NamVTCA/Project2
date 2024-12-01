<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\User;
use App\Http\Requests\ChildRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ChildController extends Controller
{
    public function index()
    {
        $children = Child::with('user')->get();
        return view('admin.children.index', compact('children'));
    }

    public function create()
    { 
        $users = User::where('role', '!=', 0)->get();
        return view('admin.children.create',compact('users'));
    }

    public function store(ChildRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) 
        {
            $data['img'] = $request->file('img')->store('children', 'public');
        } else {
            $data['img'] = null;
        }

        Child::create($data);

        return redirect()->route('admin.children.index')
            ->with('success', 'Tạo thông tin trẻ thành công.');
    }

    public function edit(Child $child)
    {
        $users = User::where('role', '!=', 0)->get();
        return view('admin.children.edit', compact('child', 'users'));
    }

    public function update(ChildRequest $request, Child $child)
    {
        $data = $request->validated();   

        if ($request->hasFile('img')) 
        {
            if ($child->img) 
            {
                Storage::disk('public')->delete($child->img);
            }
            $data['img'] = $request->file('img')->store('children', 'public');
        } 
        else 
        {
            unset($data['img']); 
        }   

        $child->update($data);
        
        return redirect()->route('admin.children.index')
            ->with('success', 'Cập nhật thông tin trẻ thành công.');
    }
}