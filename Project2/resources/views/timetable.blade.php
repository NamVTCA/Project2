{{-- @extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
<main class="timetable-container">
    <h1 class="page-title">Nursery Schedule</h1>

    <!-- Bộ lọc -->
    <div class="filter">
        <label for="date">Ngày</label>
        <input type="date" id="date">
        <label for="week">Tuần Thứ</label>
        <select id="week">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </div>

    <!-- Thời gian biểu -->
    <div class="timetable">
        <form id="timetable-form">
            <table>
                <thead>
                    <tr>
                        <th>Tiết</th>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 7; $i++)
                    <tr>
                        <th>{{ $i }}</th>
                        @for ($j = 1; $j <= 6; $j++)
                        <td><input type="text" name="slot[{{ $i }}][{{ $j }}]" placeholder="Label"></td>
                        @endfor
                    </tr>
                    @endfor
                </tbody>
            </table>
            <button type="submit" class="save-btn">Lưu Thời Khóa Biểu</button>
        </form>
    </div>
</main>
@endsection --}}
