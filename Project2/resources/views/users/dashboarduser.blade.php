@extends('layouts.dashboard')

@section('title', 'Parent Dashboard')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark">
        Thông Tin Học Sinh
    </div>
    <div class="card-body">
        <ul>
            <li><a href="#">Thông tin con em</a></li>
            <li><a href="#">Lịch học</a></li>
            <li><a href="#">Thông báo từ nhà trường</a></li>
        </ul>
    </div>
</div>
@endsection
