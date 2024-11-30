<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    public function index()
    {
        $accounts = User::all(); 
        return view('admin.users.index', compact('accounts'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }    

    public function store(UserRequest $request)
    {
        $data = $request->validate();
    
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('users', 'public');
        }
    
        $data['password'] = Hash::make($data['password']);
    
        User::create($data);
    
        session()->flash('success', 'Tài khoản đã được tạo thành công!');
    
        return redirect()->route('admin.users.index');
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validate();

        if ($request->hasFile('img')) {
            if ($user->img) {
                Storage::disk('public')->delete($user->img);
            }
            $data['img'] = $request->file('img')->store('users', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        session()->flash('success', 'Tài khoản đã được cập nhật!');
        return redirect()->route('admin.users.index');
    }
}
