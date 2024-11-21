<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    function admin(){ return view('admin/dashboardadmin'); } 
    function teacher(){ return view('teacher/dashboardteacher'); } 
    function user(){ return view('user/dashboarduser'); }


      public function showFogot(){
        return view('forgotpassword');
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
        Auth::login($user);

    $role = $user->role;

    switch ($role) {
        case 0:
            return redirect()->route('admin');
        case 1:
            return redirect()->route('teacher');
        case 2:
            return redirect()->route('user');
        default:
            return redirect()->route('user');
    }
    
}
public function logout(Request $request)
{
 
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('showlogin')->with('message', 'Bạn đã đăng xuất thành công.');
}


public function sendResetCode(Request $request)
{
    $request->validate(['phone' => 'required']);
    $phone = $request->input('phone');
    $user = User::where('phone', $phone)->first();
    
    if (!$user) {
        return back()->withErrors(['phone' => 'Số điện thoại không tồn tại']);
    } else {
        $resetCode = Str::random(6);
        Session::put('reset_code', $resetCode);
        
        // Gửi mã OTP qua email
        Mail::raw("Mã xác nhận để đặt lại mật khẩu của bạn là: $resetCode", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

        // Thay vì sử dụng redirect()->route, dùng session flash để thông báo
        session()->flash('message', 'Mã xác nhận đã được gửi');
        
        return redirect()->route('showfogot');  // Chỉ chuyển hướng đến trang showfogot
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
            return response()->json(['success' => false, 'message' => 'Số điện thoại hoặc email không tồn tại.']);
        }

        if ($codeInput != Session::get('reset_code')) {
            return response()->json(['success' => false, 'message' => 'Mã xác nhận không hợp lệ.']);
        }

        // Cập nhật mật khẩu
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['success' => true, 'message' => 'Mật khẩu đã được thay đổi thành công!']);
    }
}





