<?php

namespace App\Http\Controllers;

use App\Models\child;
use App\Models\childclass;
use App\Models\classroom;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\weekevaluate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('showlogin')->with('error','Sai tài khoản hoặc mật khẩu');
        }
    Auth::login($user);
    $user = Auth::user(); 
    $role = $user->role;
    if ($role == 1) {
    $classrooms = $user->classroom;
    $students = [];
    $parents = [];
    if ($classrooms) {
        $students = $classrooms->children;
        $parents = $students->map(function ($student) {
            return $student->user; 
        })->filter(); 
    }
    }
    $id = $user->id;
    $children = Child::where('user_id', $id)->get();
  switch ($role) {
    case 0:
        $statisticsData = $this->getMonthlyStatistics();
        return view('admin.dashboardadmin', $statisticsData);
        case 1:
            if (!$classrooms ) {
                return redirect()->route('showlogin')->with('error','Giáo viên chưa có lớp');
}
            else {
                 return view('teacher.dashboardteacher', [
        'classrooms' => $classrooms,
        'students' => $students,
        'parents' => $parents, 
        'children'=> $children,
    ]);
            }
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
    $request->validate(['phone' => 'required|exists:users,phone']);
    $phone = $request->input('phone');
    $user = User::where('phone', $phone)->first();
    
    if (!$user) {
        return back()->withErrors(['phone' => 'Số điện thoại không tồn tại']);
    } 
        $resetCode = Str::random(6);
        Session::put('reset_code', $resetCode);
         Session::put('phone', $phone);
        Mail::raw("Mã xác nhận để đặt lại mật khẩu của bạn là: $resetCode", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

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
        return redirect()->route('showlogin')->with('message', 'Mã không tồn tại hoặt sai');
    }

    $user->password = Hash::make($request->input('new_password'));
    $user->save();
return redirect()->route('showlogin')->with('message', 'Đổi mật khẩu thành công');
}


public function getMonthlyStatistics($month = null)
{
    $queryCondition = $month ? [['MONTH(created_at)', '=', $month]] : [];

    $statistics = DB::table('children')
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_students')
        ->when($month, function($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->groupBy('month')
        ->get();

    $newStudents = DB::table('children')
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as new_students')
        ->when($month, function($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->groupBy('month')
        ->get();

    $newTeachers = DB::table('users')
        ->where('role', 1)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as new_teachers')
        ->when($month, function($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->groupBy('month')
        ->get();

    $newParents = DB::table('users')
        ->where('role', 2)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as new_parents')
        ->when($month, function($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->groupBy('month')
        ->get();

    $feedbacks = DB::table('feedback')
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_feedbacks')
        ->when($month, function($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->groupBy('month')
        ->get();

    return compact('statistics', 'newStudents', 'newTeachers', 'newParents', 'feedbacks');
}

public function dashboard(Request $request)
{
    $month = $request->query('month');
    $statisticsData = $this->getMonthlyStatistics($month);
    return view('admin.dashboardadmin', $statisticsData);
}

}





