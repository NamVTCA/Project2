<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [ 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'email', 'max:255', 
                Rule::unique('users')->ignore($this->user)],
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            'id_number' => ['required', 'regex:/^[0-9\s]+$/', 'max:255'],
            'address' => 'required|string|max:255',
            'role' => 'required|integer|in:0,1,2',
            'status' => 'required|integer|in:0,1',
            'gender' => 'required|string|in:male,female,other',
            'phone' => ['required', 'regex:/^[0-9\s]+$/', 'max:20'],
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'id_number.required' => 'Vui lòng nhập số CMND/CCCD',
            'id_number.regex' => 'CMND/CCCD chỉ được chứa số và khoảng trắng',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'role.required' => 'Vui lòng chọn vai trò',
            'role.in' => 'Vai trò không hợp lệ',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ',
            'gender.required' => 'Vui lòng chọn giới tính',
            'gender.in' => 'Giới tính không hợp lệ',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại chỉ được chứa số và khoảng trắng',
            'img.image' => 'File phải là hình ảnh',
            'img.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg',
            'img.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ];
    }
}
