@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
<div class="back-button">
    <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Quay về
    </a>
</div>
<main class="timetable-container">  
    <h1 class="page-title">Chỉnh Sửa Thời Khóa Biểu</h1>
    <div class="timetable">
        <form id="timetable-form" action="{{ route('timetable.save') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="form-group">
                <label for="semester">Học kỳ:</label>
                <input type="text" id="semester" name="semester" placeholder="Nhập học kỳ (Ngày bắt đầu - Ngày kết thúc) Ví Dụ: Học kỳ 1(13/12/2024 - 13/4/2025)" required>
            </div>
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
            'break_1' => '9:00 - 9:35 Giờ ra chơi buổi sáng', // Giờ ra chơi buổi sáng
            '3' => '9:45 - 10:15',
            '4' => '10:30 - 11:15',
            'break_2' => 'Nghỉ nửa buổi', // Nghỉ nửa buổi
            '5' => '13:30 - 14:05',
            '6' => '14:15 - 14:50',
            'break_3' => '15:00 - 15:35 Giờ ra chơi buổi chiều', // Giờ ra chơi buổi chiều
            '7' => '15:45 - 16:20',
            '8' => '16:30 - 17:05'
        ];
    @endphp

    @foreach($times as $period => $time)
        @if(str_contains($period, 'break'))
            <!-- Hàng dành cho giờ ra chơi hoặc nghỉ trưa -->
            <tr class="break-row">
                <td colspan="8" class="text-center">{{ $time }}</td>
            </tr>
        @else
            <!-- Hàng dành cho các tiết học -->
            <tr>
                <th>Tiết {{ is_numeric($period) ? $period : '' }}</th>
                <td>{{ $time }}</td>
                @for($day = 2; $day <= 7; $day++)
                    <td>
                        <input 
                            type="text" 
                            class="t{{ $day }} p{{ $period }}" 
                            name="schedule[t{{ $day }}][p{{ $period }}]" 
                            placeholder="Nhập Môn" 
                            required>
                    </td>
                @endfor
            </tr>
        @endif
    @endforeach
</tbody>

            </table>
            <button type="submit" class="save-btn">Lưu Thời Khóa Biểu</button>
            <a href="{{ route('timetable.view') }}" class="btn btn-light btn-sm">Xem Lịch Học</a>
            <a href="{{ route('timetable.manage') }}" class="btn btn-light btn-sm">Xem Học Kỳ</a>
        </form>
        @if (session('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif
    </div>
</main>

<script>
    function validateForm() {
        const inputs = document.querySelectorAll('#timetable-form input[type="text"]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                alert('Vui lòng điền đầy đủ tất cả các trường.');
                input.focus();
                return false;
            }
        }
        return true;
    }

            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection
