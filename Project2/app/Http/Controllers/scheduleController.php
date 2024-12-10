<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\schedule;
use App\Models\schedule_info;
use App\Models\subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class scheduleController extends Controller
{
public function getScheduleDetails(Request $request)
{
    $classroomId = $request->query('classroom_id');
    $date = $request->query('date');

    if (!$classroomId || !$date) {
        return response()->json([], 400);
    }
    $schedules = Schedule::where('classroom_id', $classroomId)
                         ->where('date', $date)
                         ->with(['schedule_info.subject'])
                         ->get();

    if ($schedules->isNotEmpty()) {
        $details = $schedules->flatMap(function ($schedule) {
            return $schedule->schedule_info->map(function ($info) {
                return [
                    'schedule_id' => $info->schedule_id,
                    'name' => $info->name,
                    'subject_name' => $info->subject->name ?? 'Không rõ'
                ];
            });
        });

        return response()->json($details, 200);
    }

    return response()->json([], 200);
}
    public function deleteSchedule(Request $request)
    
{
    $scheduleId = $request->query('schedule_id');
    if ($scheduleId) {
        $schedule = Schedule::find($scheduleId);
        if ($schedule) {
            $schedule->schedule_info()->delete(); 
            $schedule->delete(); 
            return response()->json(['success' => true], 200);
        }
    }

    return response()->json(['success' => false], 404);
}

    public function index(Request $request){
        $classrooms = classroom::all();
         $classroomId = $request->input('classroom_id');
        $date = $request->input('date');
        
    return view('schedule/schedule',compact('classrooms'));
    }
      public function user(Request $request){
        $classrooms = classroom::all();
         $classroomId = $request->input('classroom_id');
        $date = $request->input('date');
        
    return view('schedule/scheduleUser',compact('classrooms'));
    }
       public function test(Request $request){
        $classrooms = classroom::all();
         $classroomId = $request->input('classroom_id');
        $date = $request->input('date');
        
    return view('schedule.test',compact('classrooms'));
    }
   public function create()
    {
        $subjects = subject::all();
        $classrooms = Classroom::all();
        return view('schedule.index', compact('classrooms','subjects'));
    }

   function store(Request $request)
{
    $request->validate([
        'classroom_id' => 'required|exists:classrooms,id',
        'subject_id' => 'required|exists:subjects,id',
        'date' => 'required|date',
        'lesson' => 'required',
    ]);

    $schedule = Schedule::with('classroom', 'schedule_info')
        ->where('classroom_id', $request->classroom_id)
        ->where('date', $request->date)
        ->whereHas('schedule_info', function ($query) use ($request) {
        $query->where('name', $request->lesson); 
    })
    ->first();
    if ($schedule) {
        return redirect()->route('schedule.create')->withErrors(['error' => 'Lịch học bị trùng!']);
    }

    $schedule = Schedule::create([
        'classroom_id' => $request->classroom_id,
        'date' => $request->date,
        'lesson' => $request->lesson,
    ]);

    schedule_info::create([
        'schedule_id' => $schedule->id,  
        'subject_id' => $request->subject_id,
        'name' => $request->lesson, 
    ]);

    return redirect()->route('schedule.create')->with('success', 'Lịch học đã được tạo thành công!');
}


/////////////////////////////////////////////////////////////////////////////////////////////
 public function saveTimetable(Request $request)
    {
        $semester = $request->input('semester');
        $schedule = $request->input('schedule');

        // Lưu dữ liệu vào session (không dùng DB)
        session(["timetable.$semester" => $schedule]);

        return redirect()->route('timetable', ['semester' => $semester]);
    }

    public function viewTimetable(Request $request)
    {
        $semesters = array_keys(session('timetable', [])); // Lấy danh sách học kỳ
        $selectedSemester = $request->get('semester', $semesters[0] ?? null);
        $schedule = session("timetable.$selectedSemester", []);

        return view('timebladeT', compact('semesters', 'selectedSemester', 'schedule'));
    }
    public function manageSemesters()
{
    $semesters = array_keys(session('timetable', []));
    return view('manage', compact('semesters'));
}

public function deleteSemester(Request $request, $semester)
{
    $timetable = session('timetable', []);
    unset($timetable[$semester]);
    session(['timetable' => $timetable]);

    return redirect()->route('timetable.manage')->with('success', "Đã xóa học kỳ '$semester'.");
}

public function exportPDF(Request $request)
{
    $selectedSemester = $request->get('semester');
    $schedule = session("timetable.$selectedSemester", []);
    $times = [
        '1' => '7:30 - 8:05',
        '2' => '8:15 - 8:50',
        'break_1' => '9:00 - 9:35 Giờ ra chơi buổi sáng',
        '3' => '9:45 - 10:15',
        '4' => '10:30 - 11:15',
        'break_2' => 'Nghỉ nửa buổi',
        '5' => '13:30 - 14:05',
        '6' => '14:15 - 14:50',
        'break_3' => '15:00 - 15:35 Giờ ra chơi buổi chiều',
        '7' => '15:45 - 16:20',
        '8' => '16:30 - 17:05'
    ];

    $pdf = Pdf::loadView('schedule.pdf', compact('schedule', 'times', 'selectedSemester'));
    return $pdf->download("ThoiKhoaBieu_HocKy_$selectedSemester.pdf");
}



}
