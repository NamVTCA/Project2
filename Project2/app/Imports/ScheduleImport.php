<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ScheduleImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
{
    public function __construct()
    {
        Schedule::truncate();
    }

    public function model(array $row)
    {
        if (empty($row[0]) || $row[0] === 'ID' || $row[0] === 'Thời gian') {
            return null;
        }

        return new Schedule([
            'time' => $row[0],
            'khoi_la' => $row[1],
            'khoi_choi' => $row[2],
            'khoi_mam' => $row[3],
            'khoi_25_36' => $row[4],
            'khoi_18_24' => $row[5]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}