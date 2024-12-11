<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['ho_ten'],
            'email'    => $row['email'],
            'password' => Hash::make($row['mat_khau']), 
            'id_number' => $row['so_cccdcmnd'],
            'address'   => $row['dia_chi'],
            'role'      => $row['vai_tro'],
            'status'    => $row['trang_thai'],
            'gender'    => $row['gioi_tinh'],
            'phone'     => $row['so_dien_thoai'],
        ]);
    }

    public function rules(): array
    {
    return [
        'ho_ten' => [ 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'mat_khau' => 'required|min:6',
        'so_cccdcmnd' => ['required', 'regex:/^[0-9\s]+$/', 'max:12', 'min:9'],
        'dia_chi' => 'required|string|max:255',
        'vai_tro' => 'required|integer|in:1,2',
        'trang_thai' => 'required|integer|in:0,1',
        'gioi_tinh' => 'required|string|in:male,female,other',
        'so_dien_thoai' => ['required', 'regex:/^[0-9\s]+$/', 'max:20'],
    ];
    }

    public function customValidationMessages()
    {
        return [
            'ho_ten.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'so_cccdcmnd.required' => 'Vui lòng nhập số CMND/CCCD',
            'so_cccdcmnd.regex' => 'CMND/CCCD chỉ được chứa số và khoảng trắng',
            'dia_chi.required' => 'Vui lòng nhập địa chỉ',
            'vai_tro.required' => 'Vui lòng chọn vai trò',
            'vai_tro.in' => 'Vai trò không hợp lệ',
            'trang_thai.required' => 'Vui lòng nhập trạng thái',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính',
            'gioi_tinh.in' => 'Giới tính không hợp lệ',
            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại',
            'so_dien_thoai.regex' => 'Số điện thoại chỉ được chứa số và khoảng trắng',
        ];
    }
}