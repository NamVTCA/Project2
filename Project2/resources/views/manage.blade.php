@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
<main class="timetable-container">
    <h1 class="page-title">Quản Lý Học Kỳ</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="semester-list">
        <h2>Danh Sách Học Kỳ</h2>
        @if(count($semesters) > 0)
            <ul>
                @foreach($semesters as $semester)
                    <li>
                        <span>{{ $semester }}</span>
                        <div class="actions">
                            <form action="{{ route('timetable.deleteSemester', ['semester' => $semester]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xóa học kỳ này?')">Xóa</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có học kỳ nào được tạo.</p>
        @endif
    </div>
</main>
@endsection
