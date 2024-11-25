<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::all(); // Lấy danh sách tài khoản
        return view('accountmanagement', compact('accounts'));
    }

    public function create()
    {
        return view('accountcreation'); // Giao diện thêm tài khoản
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'active' => 'required|boolean',
        ]);

        User::create($request->all());

        return redirect()->route('account.index')->with('success', 'Tài khoản đã được tạo!');
    }

    public function edit($id)
    {
        $account = User::findOrFail($id);
        return view('accountedit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = User::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'role' => 'required|string',
            'active' => 'required|boolean',
        ]);

        $account->update($request->all());

        return redirect()->route('account.index')->with('success', 'Tài khoản đã được cập nhật!');
    }

    public function destroy($id)
    {
        $account = User::findOrFail($id);
        $account->delete();

        return redirect()->route('account.index')->with('success', 'Tài khoản đã được xóa!');
    }
    //
}