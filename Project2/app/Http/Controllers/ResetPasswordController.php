<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function showChangepasswordForm()
    {
        return view('resetpassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|same:new_password'
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp với mật khẩu mới'
        ]);
    

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng');
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
    
        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
    
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đổi mật khẩu');
        }    
}
}
