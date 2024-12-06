<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\User;
use App\Models\weekevaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class evaluateController extends Controller
{
    function index($id){
        $classrooms= classroom::where('user_id',$id)->get();
        $data = [];
        foreach ($classrooms as $classroom) {
        $children = array_merge($data, $classroom->children->toArray());

    }
    $children = (object) $data;
     return response()->json($data);
    }
function show(){
    $user = Auth::user();
    $id = $user->id;
    
    // Lấy các classrooms thuộc user
    $classrooms = Classroom::where('user_id', $id)->get();
    
    $data = collect(); // Khởi tạo một Collection rỗng
    
    foreach ($classrooms as $classroom) {
        $data = $data->merge($classroom->children); // Hợp nhất Collection
    }
    
    // Không cần ép kiểu thủ công
    $children = $data;
    
    return view('evaluate.index', compact('children'));
}
public function evaluatecomment(Request $request)
{
    $request->validate([
    'comment' => 'required|max:255',
    'point' => 'required|numeric|min:0|max:10',
    'date' => 'required|date|date_equals:today',
    'child_id' => 'required|exists:children,id'
], [
    'comment.required' => 'Vui lòng nhập nhận xét.',
    'point.required' => 'Vui lòng chọn điểm.',
    'date.date_equals' => 'Ngày không được vượt quá hôm nay.',
    'child_id.exists' => 'Học sinh được chọn không tồn tại.'
]);
    $evaluate = weekevaluate::with('child')
                        ->where('child_id', $request->input('child_id'))
                        ->where('date', $request->input('date'))
                        ->first();
    if ($evaluate) {
         return redirect()->back()->withErrors(['error' => 'Lịch bị trùng!']);
     }
    weekevaluate::create([
        'comment' => $request->input('comment'),
        'point' => $request->input('point'),
        'child_id' => $request->input('child_id'),
        'date' => $request->input('date')
    ]);

    return redirect()->back()->with('success', 'Đánh giá đã được thêm thành công!');
}


}
    

