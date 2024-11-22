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
   public function create()
    {
        $subjects = subject::all();
        $classrooms = Classroom::all();
        return view('schedule.index', compact('classrooms','subjects'));
    }

   function store(Request $request)
{
    // Validate input data
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
