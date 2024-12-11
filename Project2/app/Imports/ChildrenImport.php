<?php

namespace App\Imports;

use App\Models\Child;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ChildrenImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $ngaySinh = $row['ngay_sinh'];
        $birthDate = null;

        if (is_numeric($ngaySinh)) {
            $birthDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($ngaySinh);
        } else {
             // Thử chuyển đổi từ cả hai định dạng Y-m-d và d-m-Y
            try {
                $birthDate = Carbon::createFromFormat('Y-m-d', $ngaySinh);
            } catch (\Exception $e) {
                try {
                    $birthDate = Carbon::createFromFormat('d-m-Y', $ngaySinh);
                } catch (\Exception $e) {
                    return null;
                }
            }
        }

        // Kiểm tra tính hợp lệ của ngày tháng
        if (!$birthDate || !$this->isValidDate($birthDate->format('Y-m-d'))) {
            return null;
        }

        return new Child([
            'name'     => $row['ten'],
            'birthDate'    => $birthDate->format('Y-m-d'), // Luôn lưu ở định dạng Y-m-d
            'gender'      => $this->transformGender($row['gioi_tinh']),
            'user_id' => $row['id_phu_huynh'],
            'status' => $this->transformStatus($row['trang_thai']),
        ]);
    }

    public function rules(): array
    {
        return [
            'ten' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'ngay_sinh' => 'required',
            'gioi_tinh' => 'required',
            'id_phu_huynh' => 'required|exists:users,id',
            'trang_thai' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ten.required' => 'Vui lòng nhập tên.',
            'ten.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
            'ngay_sinh.required' => 'Vui lòng nhập ngày sinh.',
            'gioi_tinh.required' => 'Vui lòng chọn giới tính.',
            'id_phu_huynh.required' => 'Vui lòng chọn phụ huynh.',
            'id_phu_huynh.exists' => 'Phụ huynh không tồn tại.',
            'trang_thai.required' => 'Vui lòng nhập trạng thái',
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
                    // Thử chuyển đổi từ cả hai định dạng Y-m-d và d-m-Y
                    try {
                        $birthDate = Carbon::createFromFormat('Y-m-d', $ngaySinh);
                    } catch (\Exception $e) {
                        try {
                            $birthDate = Carbon::createFromFormat('d-m-Y', $ngaySinh);
                        } catch (\Exception $e) {
                            $validator->errors()->add("{$key}.ngay_sinh", 'Ngày sinh không đúng định dạng.');
                            continue;
                        }
                    }
                }
    
                if ($birthDate) {
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
    // Hàm chuyển đổi giá trị giới tính
    private function transformGender($value)
    {
        $cleanedValue = Str::lower(trim($value));

        if ($cleanedValue == 'nam') {
            return 1;
        } elseif ($cleanedValue == 'nữ') {
            return 2;
        } else {
            return null; // Giới tính không hợp lệ
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
            return null; // Trạng thái không hợp lệ
        }
    }
}