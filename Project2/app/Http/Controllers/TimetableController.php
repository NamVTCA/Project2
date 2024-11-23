<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        return view('timetable');
    }

    public function save(Request $request)
    {
        $timetable = $request->input('timetable');

        // Lưu vào database (ví dụ với model Timetable)
        foreach ($timetable as $item) {
            \App\Models\timetable::updateOrCreate(
                [
                    'day' => $item['day'],
                    'slot' => $item['slot']
                ],
                [
                    'activity' => $item['value']
                ]
            );
        }

        return response()->json(['message' => 'Timetable saved successfully']);
    }
}
