@extends('layouts.app')
@section('content')
<div class="container">
    <link rel="stylesheet" href="{{ asset('css/TuitionCreate.css') }}">
    <h1>Tạo Lịch học</h1>
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
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">Tiết {{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo Lịch học</button>
    </form>
   @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
</div>
@endsection