@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        Quản lý Hệ Thống
    </div>
    <div class="card-body">
        <ul>
            <li><a href="#">Quản lý tài khoản</a></li>
            <li><a href="#">Quản lý lịch học</a></li>
            <li><a href="#">Thống kê và báo cáo</a></li>
        </ul>
    </div>
</div>
@endsection
