<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\Childclass;
use Illuminate\Http\Request;

class ChildClassController extends Controller
{
    // Hiển thị form để chọn lớp và thêm học sinh vào lớp
    public function create()
    {
        // Lấy tất cả ID của các child đã tồn tại trong bảng childclass
        $existingChildIds = ChildClass::pluck('child_Id')->toArray();
    
        // Lấy danh sách tất cả các học sinh, loại bỏ những học sinh đã có trong childclass
        $children = Child::whereNotIn('id', $existingChildIds)->get();
    
        // Lấy danh sách tất cả lớp học
        $classrooms = Classroom::all();
    
        // Truyền dữ liệu vào view
        return view('childclasscreate', compact('children', 'classrooms'));
    }

    // Xử lý thêm học sinh vào lớp học
    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
    
        // Tạo mới bản ghi trong bảng childclasses
        \App\Models\Childclass::create([
            'child_id' => $request->input('child_id'),
            'classroom_id' => $request->input('classroom_id'),
        ]);

        return redirect()->route('childclass.create')->with('success', 'Thêm học sinh vào lớp thành công!');
    }
    

    // Hiển thị danh sách học sinh đã được thêm vào lớp học
    public function index(Request $request)
    {
        $classroomId = $request->get('classroom_id'); // Lấy giá trị classroom_id từ request
        $classrooms = Classroom::all(); // Lấy danh sách tất cả lớp học
    
        // Truy vấn danh sách học sinh và lọc theo lớp (nếu có)
        $childclasses = Childclass::with(['child', 'classroom'])
            ->when($classroomId, function ($query, $classroomId) {
                return $query->where('classroom_id', $classroomId);
            })
            ->get();
    
        return view('childclassindex', compact('childclasses', 'classrooms'));
    }

    // Hiển thị form chỉnh sửa
    public function edit($child_id, $classroom_id)
    {
        $childclass = Childclass::where('child_id', $child_id)
                                ->where('classroom_id', $classroom_id)
                                ->with(['child', 'classroom'])
                                ->firstOrFail();
    
        $children = Child::all();
        $classrooms = Classroom::all();
    
        return view('childclassedit', compact('childclass', 'children', 'classrooms'));
    }
    

    // Cập nhật thông tin
    public function update(Request $request, $child_id, $classroom_id)
    {
        // Xác nhận dữ liệu hợp lệ
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
    
        // Tìm và xóa bản ghi cũ dựa trên khóa chính tổng hợp
        Childclass::where('child_id', $child_id)
            ->where('classroom_id', $classroom_id)
            ->delete();
    
        // Tạo bản ghi mới với thông tin cập nhật
        Childclass::create([
            'child_id' => $request->input('child_id'),
            'classroom_id' => $request->input('classroom_id'),
        ]);
    
        // Chuyển hướng về danh sách với thông báo thành công
        return redirect()->route('childclass.index')->with('success', 'Cập nhật lớp học thành công!');
    }
    
    

}
