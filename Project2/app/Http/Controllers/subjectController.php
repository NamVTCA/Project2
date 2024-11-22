<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;

class subjectController extends Controller
{
     public function index()
    {
        $subjects = subject::all(); 
        return view('subjects.index', compact('subjects'));
    }
    public function destroy($id)
{
    $subject = Subject::findOrFail($id); 
    $subject->delete(); 

    return redirect()->back()->with('success', 'Xóa môn học thành công!');
}
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subject::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Thêm môn học thành công!');
    }
}
