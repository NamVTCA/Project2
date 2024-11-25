<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReports()
    {
        // Lấy thông tin lớp học và các thống kê cần thiết
        $classDetails = Classroom::withCount('students') // Lấy số học sinh cho mỗi lớp
            ->get()
            ->map(function ($classroom) {
                // Tính toán học phí của lớp (Giả sử bạn có thông tin này trong model)
                $classroom->tuition = $classroom->students->count() * 1000; // Ví dụ, mỗi học sinh đóng 1000
                return $classroom;
            });

        // Truyền dữ liệu vào view
        return view('reports', compact('classDetails'));
    }
}
