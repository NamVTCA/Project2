@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
<main class="timetable-container">
    <h1 class="page-title">Xem Thời Khóa Biểu</h1>
    <div class="form-group">
        <label for="semester-select">Chọn học kỳ:</label>
        <form method="GET" action="{{ route('timetable.view') }}">
            <select id="semester-select" name="semester" onchange="this.form.submit()">
                @foreach($semesters as $semester)
                    <option value="{{ $semester }}" {{ $selectedSemester == $semester ? 'selected' : '' }}>
                        {{ $semester }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @if($schedule)
        <table>
            <thead>
                <tr>
                    <th>Tiết</th>
                    <th>Thời gian</th>
                    <th>Thứ 2</th>
                    <th>Thứ 3</th>
                    <th>Thứ 4</th>
                    <th>Thứ 5</th>
                    <th>Thứ 6</th>
                    <th>Thứ 7</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $times = [
                        '1' => '7:30 - 8:05',
                        '2' => '8:15 - 8:50',
                        '3' => '9:00 - 9:35',
                        '4' => '9:45 - 10:15',
                        '5' => '10:30 - 11:15',
                        '6' => '13:30 - 14:05',
                        '7' => '14:15 - 14:50',
                        '8' => '15:00 - 15:35',
                        '9' => '15:45 - 16:20',
                        '10' => '16:30 - 17:05'
                    ];
                @endphp
                @foreach($times as $period => $time)
                    <tr>
                        <th>Tiết {{ $period }}</th>
                        <td>{{ $time }}</td>
                        @for($day = 2; $day <= 7; $day++)
                            <td>{{ $schedule["t$day"]["p$period"] ?? '' }}</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có dữ liệu thời khóa biểu cho học kỳ này.</p>
    @endif
</main>
@endsection
