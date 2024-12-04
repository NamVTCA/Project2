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
        $data = $request->validated();

        if ($request->hasFile('img')) {
            // Lưu ảnh và lưu tên file vào cột img
            $data['img'] = $request->file('img')->store('users', 'public');
        } else {
            $data['img'] = null;
        }

        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
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
        $data = $request->validated();

        if ($request->hasFile('img')) {
            if ($user->img) {
                // Xóa ảnh cũ nếu có
                Storage::disk('public')->delete($user->img);
            }
            // Lưu ảnh mới và lưu tên file vào cột img
            $data['img'] = $request->file('img')->store('users', 'public');
        }

        // Kiểm tra và mã hóa mật khẩu mới nếu có
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Cập nhật user
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
