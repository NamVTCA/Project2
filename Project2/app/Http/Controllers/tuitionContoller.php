<?php

namespace App\Http\Controllers;

use App\Models\child;
use App\Models\childclass;
use App\Models\classroom;
use App\Models\tuition;
use App\Models\tuition_info;
use Illuminate\Http\Request;

class tuitionContoller extends Controller
{
public function index(Request $request)
{
    $children = Child::all();

    $query = tuition::with('child'); 
    if ($request->has('children_id') && $request->children_id != '') {
        $query->where('child_id', $request->children_id);
    }
   
    $tuitions = $query->get();

    return view('TuitionManagement', compact('tuitions', 'children'));
}


    

    public function create()
    {
        $classrooms = classroom::all(); 
        return view('test/tuitionCreate', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'semester' => 'required|string|max:255',
            'tuition_details' => 'required|array',
            'tuition_details.*.name' => 'required|string|max:255',
            'tuition_details.*.price' => 'required|numeric|min:0',
        ]);

        $children = Classroom::findOrFail($request->classroom_id)->children;

        foreach ($children as $child) {
            $tuition = tuition::create([
                'semester' => $request->semester,
                'child_id' => $child->id,
                'status' => 0, 
            ]);

            foreach ($request->tuition_details as $detail) {
                tuition_info::create([
                    'name' => $detail['name'],
                    'price' => $detail['price'],
                    'tuition_id' => $tuition->id,
                ]);
            }
        }

        return redirect()->route('tuition.create')->with('success', 'Tuition created successfully!');
    }
}
