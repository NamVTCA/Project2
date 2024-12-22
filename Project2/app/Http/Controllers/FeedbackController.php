<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;

class FeedbackController extends Controller
{
   
    public function index()
    {
        $feedbacks = Feedback::latest()->get(); // Lấy danh sách phản hồi mới nhất
        return view('admin.users.feedbackList', compact('feedbacks'));
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Phản hồi đã được xóa!');
    }
    function feedback(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message'=> 'required|max:255'
        ]);
        $user = User::where('role',0)->first();
        $id = $user->id;
        Feedback::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'content' => $request->input('message'),
            'user_id' => $user->id
        ]);   
        return redirect()->route('feedback')->with('success', 'Cảm ơn bạn đã gửi phản hồi');
    }
}
?>