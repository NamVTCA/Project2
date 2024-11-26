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
                            <label for="hocLuc">Học Lực:</label>
                            <textarea disabled id="hocLuc" class="form-control" rows="3" placeholder="Nhập học lực và nhận xét hôm nay"></textarea>
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
                        <label for="child_id">Học Sinh:</label>
                        <select name="child_id" id="child_id" class="form-select" required>
                    <option value="" disabled selected>-- Chọn học sinh --</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
                    </div>
                    <div class="mt-4">
                        <h5>Thông Tin Học Sinh:</h5>
                        <p><strong>Tên:</strong> {{$child->name}}</p>
                        <p><strong>Ngày sinh:</strong> {{$child->birthDate}}</p>
                        <p><strong>Giới tính:</strong> {{ ($child->gender == 1) ? 'Nam' : 'Nữ' }}</p>
                        <p><strong>Lớp:</strong> {{$evaluate}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
