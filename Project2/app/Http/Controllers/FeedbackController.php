<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Hiển thị danh sách phản hồi
    public function index()
    {
        $feedbacks = Feedback::latest()->get(); // Lấy danh sách phản hồi mới nhất
        return view('admin.users.feedbackList', compact('feedbacks'));
    }

    // Xóa phản hồi
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Phản hồi đã được xóa!');
    }
}
