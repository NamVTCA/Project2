@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-3">
    <div class="row">
        <!-- Thông tin cá nhân -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Thông Tin Cá Nhân
                </div>
                @if(Auth::check())
                <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Vai trò:</strong> {{ Auth::user()->role }}</p>
            @else
                <p>Không có thông tin người dùng.</p>
            @endif
            
            </div>
        </div>

        <!-- Thông báo -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    Thông Báo
                </div>
                <div class="card-body">
                    <ul>
                        <li><a href="#">Thông báo 1: Nội dung chi tiết</a></li>
                        <li><a href="#">Thông báo 2: Nội dung chi tiết</a></li>
                        <li><a href="#">Thông báo 3: Nội dung chi tiết</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <ul>
            <li><a href="#">Thông tin con em</a></li>
            <li><a href="#">Lịch học</a></li>
            <li><a href="#">Thông báo từ nhà trường</a></li>
        </ul>
    </div>

    <div class="row mt-4">
        <!-- Lịch sử hoạt động -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Lịch Sử Hoạt Động
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Đăng nhập vào hệ thống lúc 09:00 sáng</li>
                        <li class="list-group-item">Cập nhật thông tin cá nhân lúc 10:15 sáng</li>
                        <li class="list-group-item">Đăng ký tham gia sự kiện "Ngày hội gia đình"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
