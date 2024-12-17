<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\User;
use App\Http\Requests\ChildRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Imports\ChildrenImport;
use App\Exports\ChildrenExport;
use Maatwebsite\Excel\Facades\Excel;

class ChildController extends Controller
{
    public function index()
    {
        $children = Child::with('user')->paginate(10); // Phân trang với 10 children mỗi trang
        return view('admin.children.index', compact('children'));
    }

    public function create()
    { 
        $users = User::where('role', '!=', 0)->get();
        return view('admin.children.create',compact('users'));
    }

    public function store(ChildRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) 
        {
            $data['img'] = $request->file('img')->store('children', 'public');
        } 
        else 
        {
            $data['img'] = null;
        }

        Child::create($data);

        return redirect()->route('admin.children.index')
            ->with('success', 'Tạo thông tin trẻ thành công.');
    }

    public function edit(Child $child)
    {
        $users = User::where('role', '!=', 0)->get();
        return view('admin.children.edit', compact('child', 'users'));
    }

    public function update(ChildRequest $request, Child $child)
    {
        $data = $request->validated();   

        if ($request->hasFile('img')) 
        {
            if ($child->img) 
            {
                Storage::disk('public')->delete($child->img);
            }
            $data['img'] = $request->file('img')->store('children', 'public');
        } 
        else 
        {
            unset($data['img']); 
        }   

        $child->update($data);
        
        return redirect()->route('admin.children.index')
            ->with('success', 'Cập nhật thông tin trẻ thành công.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new ChildrenImport, $request->file('file'));
            session()->flash('success', 'Import danh sách học sinh thành công!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $rowNumber = $failure->row();
                $attribute = $failure->attribute();
                $errors = $failure->errors();
                $errorMessages[] = "Dòng {$rowNumber}, cột {$attribute}: {$errors[0]}";
            }
            return redirect()->back()->with('import_errors', $errorMessages);
        }

        return redirect()->route('admin.children.index');
    }

    public function export()
    {
        return Excel::download(new ChildrenExport, 'children.xlsx');
    }
}