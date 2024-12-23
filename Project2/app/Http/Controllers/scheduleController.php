<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\schedule;
use App\Models\schedule_info;
use App\Models\subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class scheduleController extends Controller
{

public function saveTimetable(Request $request)
{
    $semester = $request->input('semester');
    $schedule = $request->input('schedule'); // Dữ liệu thời khóa biểu

    // Đọc dữ liệu từ file JSON
    $timetables = Storage::exists('timetables.json') 
        ? json_decode(Storage::get('timetables.json'), true) 
        : [];

    // Cập nhật hoặc thêm thời khóa biểu
    $timetables[$semester] = $schedule;

    // Ghi dữ liệu trở lại file JSON
    Storage::put('timetables.json', json_encode($timetables));

    return redirect()->route('timetable', ['semester' => $semester])
        ->with('message', 'Lưu thời khóa biểu thành công');
}
    public function viewTimetable(Request $request)
{
    // Đọc dữ liệu từ file JSON
    $timetables = Storage::exists('timetables.json') 
        ? json_decode(Storage::get('timetables.json'), true) 
        : [];

    $semesters = array_keys($timetables); // Lấy danh sách các học kỳ
    $selectedSemester = $request->get('semester', $semesters[0] ?? null);
    $schedule = $timetables[$selectedSemester] ?? []; // Lấy thời khóa biểu của học kỳ được chọn

    return view('timebladeT', compact('semesters', 'selectedSemester', 'schedule'));
}
public function manageSemesters()
{
    // Đọc danh sách thời khóa biểu từ file JSON
    $timetables = Storage::exists('timetables.json') 
        ? json_decode(Storage::get('timetables.json'), true) 
        : [];

    // Lấy danh sách các học kỳ
    $semesters = array_keys($timetables);

    return view('manage', compact('semesters'));
}

public function deleteSemester(Request $request, $semester)
{
    // Đọc dữ liệu từ file JSON
    $timetables = Storage::exists('timetables.json') 
        ? json_decode(Storage::get('timetables.json'), true) 
        : [];

    // Xóa học kỳ
    unset($timetables[$semester]);

    // Ghi dữ liệu trở lại file JSON
    Storage::put('timetables.json', json_encode($timetables));

    return redirect()->route('timetable.manage')->with('success', "Đã xóa học kỳ '$semester'.");
}

public function exportPDF(Request $request)
{
    $selectedSemester = $request->get('semester');

    // Đọc dữ liệu từ file JSON
    $timetables = Storage::exists('timetables.json') 
        ? json_decode(Storage::get('timetables.json'), true) 
        : [];

    $schedule = $timetables[$selectedSemester] ?? [];

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
