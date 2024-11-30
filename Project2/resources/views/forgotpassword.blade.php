@extends('layouts.dashboard')

@section('title', 'Đặt Lại Mật Khẩu') <!-- Thay đổi tiêu đề trang -->

@section('content')
<link rel="stylesheet" href="{{ asset('css/Fogotpassword.css') }}">
<main class="reset-password-page">
      @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
@if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif 
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="logo">
        <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool">
        <h1>NURSERY PRESCHOOL</h1>
    </div>

    <form action="{{ route('otp') }}" method="get" class="send-otp-form">
        @csrf
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
        <button type="submit" class="btn btn-primary">Gửi mã xác nhận</button>
    </form>

    <form action="{{ route('forgotpassword') }}" method="post" class="reset-password-form">
        @csrf
        <input type="hidden" name="phone" id="phone" value="{{ session('phone') }}">
        <label for="otp">Mã xác nhận</label>
        <input type="text" id="otp" name="otp" placeholder="Nhập mã xác nhận" required>
        @error('otp')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <label for="new-password">Mật khẩu mới</label>
        <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
        @error('new_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <label for="confirm-password">Nhập lại Mật khẩu mới</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
        @error('confirm_password')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <button type="submit" class="reset-password-btn">Đặt lại mật khẩu</button>
        
        <div id="resetMessage"></div>
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </form>
</main>
@endsection
