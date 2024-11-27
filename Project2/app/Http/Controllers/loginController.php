<?php

namespace App\Http\Controllers;

use App\Models\child;
use App\Models\childclass;
use App\Models\classroom;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\weekevaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class loginController extends Controller
{
    function admin(){ return view('admin/dashboardadmin'); } 
    function teacher(){ return view('teacher/dashboardteacher'); } 
    function user(){ return view('users/dashboarduser'); }


    public function showFogot(){
        return view('forgotpassword');
    }
    function showLogin(){
        return view('login');
    }
  public function getStudentDetails(Request $request)
{
    $childId = $request->query('child_id');
    $date = $request->query('date');

    $child = Child::with(['classroom'])->find($childId);

    if (!$child) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy học sinh']);
    }

    $evaluation = WeekEvaluate::where('child_id', $childId)->where('date', $date)->first();

    $classroom = $child->classroom->pluck('name')->first();

    return response()->json([
        'success' => true,
        'student' => [
            'name' => $child->name,
            'birthDate' => $child->birthDate,
            'gender' => $child->gender,
            'className' => $classroom,
        ],
        'evaluation' => $evaluation,
    ]);
}
    public function login(Request $request)
    {
        
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
        $id = $user->id;
        $children = Child::where('user_id', $id)->get();
        $role = $user->role;

    switch ($role) {
        case 0:
            return view('admin/dashboardadmin');
        case 1:
            return view('teacher.dashboardteacher',compact('children'));
        case 2:
            return view('users.dashboarduser',compact('children'));
        default:
            return view('users.dashboarduser',compact('children'));
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
    } 
        $resetCode = Str::random(6);
        Session::put('reset_code', $resetCode);
         Session::put('phone', $phone);
        // Gửi mã OTP qua email
        Mail::raw("Mã xác nhận để đặt lại mật khẩu của bạn là: $resetCode", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

        // Thay vì sử dụng redirect()->route, dùng session flash để thông báo
        session()->flash('message', 'Mã xác nhận đã được gửi');
        
         return redirect()->route('showfogot')->withInput(['phone' => $phone]);
}


public function resetPassword(Request $request)
{
    $request->validate([
        'otp' => 'required|string',
        'phone' => 'required|string',
        'new_password' => 'required|string|min:8|same:confirm_password',
    ]);

    $codeInput = $request->input('otp');
    $phone = $request->input('phone');
    $user = User::where('phone', $phone)->first();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Số điện thoại không tồn tại.']);
    }

    if ($codeInput != Session::get('reset_code')) {
        return response()->json(['success' => false, 'message' => 'Mã xác nhận không hợp lệ.']);
    }

    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    return redirect()->route('showfogot');
}
}





