<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;

class subjectController extends Controller
{
public function index()
    {
        $subjects = Subject::all();
        return view('subject.index', compact('subjects'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Cập nhật môn học thành công!');
    }
}
