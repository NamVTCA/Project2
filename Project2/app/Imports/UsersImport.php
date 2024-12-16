<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new User([
            'name'     => $row['ho_ten'],
            'email'    => $row['email'],
            'password' => Hash::make($row['mat_khau']),
            'id_number' => $row['so_cccdcmnd'],
            'address'   => $row['dia_chi'],
            'role'      => $this->transformRole($row['vai_tro']),
            'status'    => $this->transformStatus($row['trang_thai']),
            'gender'    => $this->transformGender($row['gioi_tinh']),
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
            'vai_tro' => 'required',
            'trang_thai' => 'required',
            'gioi_tinh' => 'required',
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
            'mat_khau.required' => 'Vui lòng nhập mật khẩu',
            'mat_khau.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'so_cccdcmnd.required' => 'Vui lòng nhập số CMND/CCCD',
            'so_cccdcmnd.regex' => 'CMND/CCCD chỉ được chứa số và khoảng trắng',
            'dia_chi.required' => 'Vui lòng nhập địa chỉ',
            'vai_tro.required' => 'Vui lòng chọn vai trò',
            'trang_thai.required' => 'Vui lòng nhập trạng thái',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính',
            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại',
            'so_dien_thoai.regex' => 'Số điện thoại chỉ được chứa số và khoảng trắng',
        ];
    }

    // Hàm chuyển đổi giá trị giới tính
    private function transformGender($value)
    {
        $cleanedValue = Str::lower(trim($value));

        if ($cleanedValue == 'nam') {
            return 'male';
        } elseif ($cleanedValue == 'nữ') {
            return 'female';
        } else {
            return null; // Không hợp lệ, sẽ bị rules() bắt lỗi
        }
    }

    // Hàm chuyển đổi giá trị vai trò
    private function transformRole($value)
    {
        $cleanedValue = Str::lower(trim($value));

        if ($cleanedValue == 'giáo viên') {
            return 1;
        } elseif ($cleanedValue == 'phụ huynh') {
            return 2;
        } else {
            return null;
        }
    }

    // Hàm chuyển đổi giá trị trạng thái
    private function transformStatus($value)
    {
        $cleanedValue = Str::lower(trim($value));

        if ($cleanedValue == 'hoạt động') {
            return 1;
        } elseif ($cleanedValue == 'không hoạt động') {
            return 0;
        } else {
            return null;
        }
    }
}