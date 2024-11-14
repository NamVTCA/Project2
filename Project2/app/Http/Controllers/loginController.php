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
    
    public function showReset(){
        return view('resetpassword');
    }
      public function login(Request $request){
    $request->validate([
        'username' => 'required',
        'password' => 'required|min:6',
    ]);

    $identifier = $request->input('username');
    
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = User::where('email', $identifier)->first();
    } else {
        $user = User::where('phone', $identifier)->first();
    }

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid email/phone or password']);
        
    }
    else{
        $role = $user->role;
        if ($role == 1) {
            # code
        }
        elseif($role == 2){
            # code
        }
        else{
            #code
        }
    }

}
 public function sendResetCode(Request $request)
    {
        $request->validate(['username' => 'required|exists:users']);
        $identifier = $request->input('username');
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = User::where('email', $identifier)->first();
    } else {
        $user = User::where('phone', $identifier)->first();
    }
        $resetCode = Str::random(6);
            Session::put('reset_code', $resetCode);
        Mail::raw("Mã xác nhận để đặt lại mật khẩu của bạn là: $resetCode", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

        return back()->with('status', 'Mã xác nhận đã được gửi qua email của bạn.');
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_code' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $codeInput = $request->input('resetCode');
        $user = User::where('email', $request->email)->first();
        if ($codeInput != Session::get('reset_code')) {
            return back()->withErrors(['reset_code' => 'Mã xác nhận không hợp lệ ']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }
}
