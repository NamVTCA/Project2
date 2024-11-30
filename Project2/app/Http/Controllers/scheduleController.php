<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\schedule;
use App\Models\schedule_info;
use App\Models\subject;
use Illuminate\Http\Request;
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

}
