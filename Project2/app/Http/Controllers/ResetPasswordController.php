<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('resetpassword');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::find(Auth::id());
        
        if (!Hash::check($request->password, $user->password)) 
        {
            return back()->withErrors(['password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Đổi mật khẩu thành công!');
    }
}
