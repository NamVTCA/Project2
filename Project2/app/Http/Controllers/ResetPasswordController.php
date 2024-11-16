<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function handleReset(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
            'otp' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.exists' => 'Số điện thoại không tồn tại trong hệ thống.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        
        if ($request->otp !== '123456') { 
            return response()->json(['message' => 'Mã xác nhận không chính xác.'], 422);
        }

        
        $user = User::where('phone', $request->phone)->first();

        
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Mật khẩu đã được đặt lại thành công.'], 200);
    }
}

