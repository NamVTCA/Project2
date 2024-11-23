<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\schedule;
use App\Models\schedule_info;
use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class scheduleController extends Controller
{
    public function getDetails(Request $request)
{
    $classroomId = $request->input('classroom_id');
    $date = $request->input('date');

    $schedules = Schedule::where('classroom_id', $classroomId)
        ->where('date', $date)
        ->with(['schedule_info.subjects']) 
        ->get();

    $result = [];
    foreach ($schedules as $schedule) {
        foreach ($schedule->schedule_info as $info) {
            $subjectNames = $info->subjects->pluck('name')->join(', '); 
            $result[] = [
                'id' => $info->id,
                'schedule_id' => $schedule->id,
                'name' => $info->name,
                'subject_name' => $subjectNames,
            ];
        }
    }

    return response()->json($result);
}

    public function delete(Request $request)
{
    $scheduleId = $request->input('schedule_id');
    $infoId = $request->input('id');

    $scheduleInfo = schedule_info::where('schedule_id', $scheduleId)->where('id', $infoId)->first();
    if ($scheduleInfo) {
        $scheduleInfo->subjects()->detach(); // Xóa mối quan hệ many-to-many
        $scheduleInfo->delete(); // Xóa bản ghi trong bảng schedule_info
        return response()->json(['success' => 'Đã xóa thành công']);
    }

    return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
}
    public function index(){
        $classrooms = classroom::all();
        return view('schedule/schedule',compact('classrooms'));
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
        'lesson' => 'required|integer|between:1,10',
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
