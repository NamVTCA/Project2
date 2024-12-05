@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
<main class="timetable-container">
    <h1 class="page-title">Chỉnh Sửa Thời Khóa Biểu</h1>
    <div class="timetable">
        <form id="timetable-form" action="{{ route('timetable.save') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="form-group">
                <label for="semester">Học kỳ:</label>
                <input type="text" id="semester" name="semester" placeholder="Nhập học kỳ" required>
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
                                <td>
                                    <input type="text" class="t{{ $day }} p{{ $period }}" name="schedule[t{{ $day }}][p{{ $period }}]" placeholder="Label" required>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="save-btn">Lưu Thời Khóa Biểu</button>
            <a href="{{ route('timetable.view') }}" class="btn btn-light btn-sm">Xem Lịch Học</a>
            <a href="{{ route('timetable.manage') }}" class="btn btn-light btn-sm">Xem Học Kỳ</a>
        </form>
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
</script>
@endsection
