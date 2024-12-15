<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;



class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role', '!=', 0)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Họ Tên',
            'Email',
            'Vai Trò',
            'Số CCCD/CMND',
            'Địa Chỉ',
            'Giới Tính',
            'Số Điện Thoại'
        ];
    }
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role == 1 ? 'Giáo viên' : 'Phụ huynh',
            $user->id_number,
            $user->address,
            $user->gender,
            $user->phone,
        ];
    }
}