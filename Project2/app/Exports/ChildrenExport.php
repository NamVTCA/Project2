<?php

namespace App\Exports;

use App\Models\Child;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChildrenExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function collection()
    {
        return Child::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Tên', 
            'Ngày Sinh',
            'Giới Tính',
            'Phụ Huynh',
            'Trạng Thái',
        ];
    }

    public function map($child): array
    {
        return [
            $child->name,
            $child->birthDate,
            $child->gender == 1 ? 'Nam' : 'Nữ',
            $child->user->name, 
            $child->status == 1 ? 'Hoạt động' : 'Không hoạt động',
        ];
    }
}