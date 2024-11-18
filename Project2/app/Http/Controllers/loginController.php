<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
      public function showFogot(){
        return view('fogotpassword');
    }
    function showLogin(){
        return view('login');
    }
  
    public function login(Request $request){
    $request->validate([
        'phone' => 'required',
        'password' => 'required',
    ]);
    $identifier = $request->input('phone');
    
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = User::where('email', $identifier)->first();
    } else {
        $user = User::where('phone', $identifier)->first();
    }

    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->route('showlogin')->with('message','invalid phone or email');
    }
        $role = $user->role;
        if ($role == 2) {
            return view('home');
        }
        elseif($role == 1){
            return view('schedule');
        }
        else{
            #code
        }
    
}
 public function sendResetCode(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $phone = $request->input('phone');
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
        return back()->withErrors(['phone' => 'Số điện thoại không tồn tại']);
        }
        else{
        $resetCode = Str::random(6);
        Session::put('reset_code', $resetCode);
        Mail::raw("Mã xác nhận để đặt lại mật khẩu của bạn là: $resetCode", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

        return redirect()->route('showfogot', ['message' => 'Mã xác nhận đã được gửi' ]);
        }
       
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
            'phone' => 'required|string',
            'new_password' => 'required|string|min:8|same:confirm_password',
        ]);
        $codeInput = $request->input('otp');
        $identifier = $request->input('phone');
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = User::where('email', $identifier)->first();
        } else {
        $user = User::where('phone', $identifier)->first();
        }
        if (!$user) {
        return back()->withErrors(['phone' => 'Số điện thoại không tồn tại']);
        }
        if ($codeInput != Session::get('reset_code')) {
            return back()->withErrors(['reset_code' => 'Mã xác nhận không hợp lệ ']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('showfogot')->with('message', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }
}
