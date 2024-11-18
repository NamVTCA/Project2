@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        Quản lý Lớp Học
    </div>
    <div class="card-body">
        <ul>
            <li><a href="#">Danh sách học sinh</a></li>
            <li><a href="#">Lên lịch giảng dạy</a></li>
            <li><a href="#">Theo dõi tiến độ học tập</a></li>
        </ul>
    </div>
</div>
@endsection
