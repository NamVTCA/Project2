<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\Childclass;
use Illuminate\Http\Request;

class ChildClassController extends Controller
{
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

    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $child = Child::findOrFail($request->input('child_id'));
        $classroom = Classroom::findOrFail($request->input('classroom_id'));

        // Kiểm tra xem phụ huynh của học sinh có phải là giáo viên của lớp học hay không
        if ($child->user_id == $classroom->user_id) {
            return redirect()->back()->with('error', 'Không thể thêm học sinh vào lớp do phụ huynh của học sinh là giáo viên của lớp này.');
        }

        // Kiểm tra xem học sinh đã có trong lớp chưa
        $existingChildClass = Childclass::where('child_id', $child->id)
                                        ->where('classroom_id', $classroom->id)
                                        ->first();

        if ($existingChildClass) {
            return redirect()->back()->with('error', 'Học sinh đã có trong lớp này.');
        }

        // Tạo mới bản ghi trong bảng childclasses
        Childclass::create([
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
    
        $children = Child::where('id',$child_id)->get();
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
    
        return redirect()->route('childclass.index')->with('success', 'Cập nhật lớp học thành công!');
    }
}