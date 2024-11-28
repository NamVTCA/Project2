<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'birthDate' => 'required|date',
            'gender' => 'required|in:1,2',
            'user_id' => 'required|exists:users,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'birthDate.required' => 'Vui lòng nhập ngày sinh.',
            'birthDate.before_or_equal' => 'Ngày sinh không được là ngày trong tương lai.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'user_id.required' => 'Vui lòng chọn phụ huynh.',
            'user_id.exists' => 'Phụ huynh không tồn tại.',
            'img.image' => 'File ảnh phải là ảnh.',
            'img.mimes' => 'File ảnh phải có định dạng jpeg, png, jpg.',
            'img.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ];
    }
}