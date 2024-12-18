<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserAccountController extends Controller
{
    public function index()
    {
        $accounts = User::where('role', '!=', 0)->Paginate(10); // Phân trang với 10 users mỗi trang
        return view('admin.users.index', compact('accounts'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }    

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) 
        {
            $data['img'] = $request->file('img')->store('users', 'public');
        } 
        else { $data['img'] = null; }

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

        if ($request->hasFile('img')) 
        {
            if ($user->img) { Storage::disk('public')->delete($user->img); }
            $data['img'] = $request->file('img')->store('users', 'public');
        }

        if (!empty($data['password'])) 
        {
            $data['password'] = Hash::make($data['password']);
        } 
        else {  unset($data['password']); }

        $user->update($data);

        session()->flash('success', 'Tài khoản đã được cập nhật!');
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        if ($user->img) { Storage::disk('public')->delete($user->img); }

        $user->delete();

        session()->flash('success', 'Tài khoản đã được xóa!');
        return redirect()->route('admin.users.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try 
        {
            Excel::import(new UsersImport, $request->file('file'));
            return redirect()->route('admin.users.index')->with('success', 'Import users thành công!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) 
        {
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) 
            {
                $rowNumber = $failure->row();
                $attribute = $failure->attribute();
                $errors = $failure->errors();
                
                foreach ($errors as $error) 
                {
                    $errorMessages[] = "Dòng {$rowNumber}: {$error}";
                }
            }

            return redirect()->back()->withErrors($errorMessages);
        }
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function teachers()
    {
        $teachers = User::where('role', 1)->get()->shuffle()->take(4);
        return view('link-to-teachers', compact('teachers')); // Sửa tên view ở đây
    }

    public function deleteAll()
{
    try {
        // Lọc và xóa tài khoản ngoại trừ role = 0 (Admin hoặc tài khoản đặc biệt)
        User::where('role', '!=', 0)->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa tất cả tài khoản thành công.');
    } catch (\Exception $e) {
        return redirect()->route('admin.users.index')->with('error', 'Xóa tất cả tài khoản thất bại. Vui lòng thử lại.');
    }
}

}