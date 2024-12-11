<?php

namespace App\Imports;

use App\Models\Child;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Carbon;

class ChildrenImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $ngaySinh = $row['ngay_sinh'];
        $birthDate = null;

        // Kiểm tra nếu giá trị ngày sinh là số
        if (is_numeric($ngaySinh)) {
            // Chuyển đổi từ Excel timestamp
            $birthDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($ngaySinh);
        } else {
            // Thử chuyển đổi từ chuỗi ngày tháng
            try {
                $birthDate = Carbon::createFromFormat('Y-m-d', $ngaySinh);
            } catch (\Exception $e) {
                // Xử lý lỗi nếu chuyển đổi không thành công
                return null;
            }
        }

        // Kiểm tra tính hợp lệ của ngày tháng
        if (!$birthDate || !$this->isValidDate($birthDate->format('Y-m-d'))) {
            return null;
        }

        return new Child([
            'name' => $row['ten'],
            'birthDate' => $birthDate->format('Y-m-d'),
            'gender' => $row['gioi_tinh'] == 'Male' ? 1 : 2,
            'user_id' => $row['id_phu_huynh'],
            'status' => $row['trang_thai'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ten' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'ngay_sinh' => 'required',
            'gioi_tinh' => 'required|in:Male,Female',
            'id_phu_huynh' => 'required|exists:users,id',
            'trang_thai' => 'nullable|in:0,1',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ten.required' => 'Vui lòng nhập tên.',
            'ten.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'ngay_sinh.required' => 'Vui lòng nhập ngày sinh.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'gioi_tinh.in' => 'Giới tính phải là Male hoặc Female.',
            'id_phu_huynh.required' => 'Vui lòng chọn phụ huynh.',
            'id_phu_huynh.exists' => 'Phụ huynh không tồn tại.',
            'trang_thai.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($validator->getData() as $key => $data) {
                $ngaySinh = $data['ngay_sinh'];
                $birthDate = null;
    
                if (is_numeric($ngaySinh)) {
                    $birthDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($ngaySinh);
                } else {
                    try {
                        $birthDate = Carbon::createFromFormat('Y-m-d', $ngaySinh);
                    } catch (\Exception $e) {
                        $validator->errors()->add("{$key}.ngay_sinh", 'Ngày sinh không đúng định dạng.');
                        continue;
                    }
                }
    
                if ($birthDate) {
                    // Chuyển đổi $birthDate thành Carbon instance nếu nó chưa phải
                    if (!($birthDate instanceof Carbon)) {
                        $birthDate = Carbon::instance($birthDate);
                    }
                    
                    $currentDate = Carbon::now();
                    $ageInMonths = $birthDate->diffInMonths($currentDate);
    
                    if ($ageInMonths < 36 || $ageInMonths > 72) {
                        $validator->errors()->add("{$key}.ngay_sinh", 'Tuổi của trẻ phải từ 3 đến 6 tuổi.');
                    }
                } else {
                    $validator->errors()->add("{$key}.ngay_sinh", 'Ngày sinh không hợp lệ.');
                }
            }
        });
    }

    // Hàm kiểm tra tính hợp lệ của ngày tháng
    private function isValidDate($date)
    {
        list($year, $month, $day) = explode('-', $date);
        return checkdate($month, $day, $year);
    }
}