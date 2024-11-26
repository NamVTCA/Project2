<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    
    
    public function index()
    {
        // Lấy toàn bộ danh sách tài khoản từ bảng users
        $accounts = User::all(); 
    
        // Trả dữ liệu về view
        return view('admin.users.index', compact('accounts'));
    }
    
    
    public function create()
    {
        return view('admin.users.create');
    }    

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'role' => 'required|string',
            'gender' => 'required|string',
            'status' => 'required|boolean',
            'img' => 'nullable|image',
        ]);
    
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('users', 'public');
        }
    
        $data['password'] = Hash::make($data['password']);
    
        User::create($data);
    
        // Flash message success
        session()->flash('success', 'Tài khoản đã được tạo thành công!');
    
        return redirect()->route('admin.users.index');
    }
    
    
    

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'active' => 'required|boolean',
            'password' => 'nullable|min:6',
            'img' => 'nullable|image',
        ]);

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

    public function destroy(User $user)
    {
        if ($user->img) {
            Storage::disk('public')->delete($user->img);
        }

        $user->delete();

        session()->flash('success', 'Tài khoản đã được xóa!');
        return redirect()->route('admin.users.index');
    }
}
