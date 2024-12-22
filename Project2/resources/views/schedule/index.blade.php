@extends('layouts.dashboard')
@section('content')
<div class="container">
    <link rel="stylesheet" href="{{ asset('css/ScheduleIndex.css') }}">
    <h1>Tạo lịch học</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
     
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <!-- Chọn lớp học -->
        <div class="form-group">
            <label for="classroom_id">Lớp học</label>
            <select name="classroom_id" id="classroom_id" class="form-control" required>
                <option value="">-- Chọn lớp học --</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Chọn môn học -->
        <div class="form-group">
            <label for="subject_id">Môn học</label>
            <select name="subject_id" id="subject_id" class="form-control" required>
                <option value="">-- Chọn môn học --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Chọn ngày học -->
        <div class="form-group">
            <label for="date">Ngày học</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <!-- Chọn tiết học -->
        <div class="form-group">
            <label for="lesson">Tiết học</label>
            <select name="lesson" id="lesson" class="form-control" required>
                <option value="">-- Chọn tiết học --</option>
                    <option value="Tiết 1 (7h30 - 8h05)">Tiết 1 (7h30 - 8h05)</option>
                    <option value="Tiết 2 (8h15 - 8h50)">Tiết 2 (8h15 - 8h50)</option>
                    <option value="Tiết 3 (9h00 - 9h35)">Tiết 3 (9h00 - 9h35)</option>
                    <option value="Tiết 4 (9h45 - 10h15)">Tiết 4 (9h45 - 10h20)</option>
                    <option value="Tiết 5 (10h30 - 11h15)">Tiết 5 (10h30 - 11h15)</option>
                    <option value="Tiết 6 (13h30 - 14h05)">Tiết 6 (13h30 - 14h05)</option>
                    <option value="Tiết 7 (14h15 - 14h50)">Tiết 7 (14h15 - 14h50)</option>
                    <option value="Tiết 8 (15h00 - 15h35)">Tiết 8 (15h00 - 15h35)</option>
                    <option value="Tiết 9 (15h45 - 16h20)">Tiết 9 (15h45 - 16h20)</option>
                    <option value="Tiết 10 (16h30 - 17h05)">Tiết 10 (16h30 - 17h05)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo lịch học</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-glow">Thêm môn Học</a>
        <a href="{{ route('schedule.show') }}" class="btn btn-glow">Xem lịch Học</a>    
    </form>
   @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
</div>
@endsection