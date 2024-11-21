<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tuition;
use App\Models\tuition_info;
use Carbon\Carbon;

class TuitionSeeder extends Seeder
{
    public function run()
    {
        // Dữ liệu mẫu cho bảng tuitions
        $tuition = Tuition::create([
            'semester' => 1,
            'status' => 0,
            'child_id' => 1, // Đảm bảo rằng child_id này tồn tại trong bảng children
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Dữ liệu mẫu cho bảng tuitions_info
        tuition_info::create([
            'name' => 'Học phí kỳ 1',
            'price' => 1000000,
            'tuition_id' => $tuition->id, // Liên kết với tuition_id vừa tạo
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
