@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/UserDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin cá nhân căn giữa -->
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    Thông Tin Cá Nhân
                </div>
                <div class="card-body text-center">
                    @if(Auth::check())
                        <!-- Hiển thị ảnh người dùng -->
                        <img src="{{ asset('img/backtoschool.png' . Auth::user()->profile_image) }}" 
                             alt="Ảnh Đại Diện" 
                             class="rounded-circle mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">

                        <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ Auth::user()->phone }}</p>
                        <p><strong>Địa Chỉ:</strong> {{ Auth::user()->address }}</p>
                        <p><strong>Căn Cước Công Dân:</strong> {{ Auth::user()->id_number }}</p>
                        <p><strong>Giới Tính:</strong> {{ Auth::user()->gender }}</p>
                    @else
                        <p>Không có thông tin người dùng.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Phần thông báo -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    Chọn Ngày và Học Lực
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="date">Ngày:</label>
                            <input type="date" id="date" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label for="hocLuc">Học Lực:</label>
                            <textarea id="hocLuc" class="form-control" rows="3" placeholder="Nhập học lực và nhận xét hôm nay"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Chọn học sinh và hiển thị thông tin -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Chọn Học Sinh
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="student">Học Sinh:</label>
                        <select id="student" class="form-control">
                            <option value="1">Nguyễn Văn A</option>
                            <option value="2">Trần Thị B</option>
                            <option value="3">Lê Văn C</option>
                        </select>
                    </div>
                    <div class="mt-4 text-center">
                        <!-- Hiển thị ảnh học sinh -->
                        <img src="{{ asset('img/Login.png') }}" 
                             id="studentImage" 
                             alt="Ảnh Học Sinh" 
                             class="rounded mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                             
                        <h5>Thông Tin Học Sinh:</h5>
                        <p><strong>Tên:</strong> Nguyễn Văn A</p>
                        <p><strong>Lớp:</strong> 10A1</p>
                        <p><strong>Giáo Viên Chủ Nhiệm:</strong> Cô Nguyễn Thị D</p>
                        <p><strong>Điểm Trung Bình:</strong> 8.5</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
