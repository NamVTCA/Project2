@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Fogotpassword.css') }}">
<main class="reset-password-page">
    <div class="logo">
        <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool">
        <h1>Nursery PreSchool</h1>
    </div>
    @if (session('success'))
        <p class="text-success">{{ session('success') }}</p>
    @endif
    <form class="reset-password-form" method="POST" action="{{ route('reset.password') }}">
        @csrf
        <label for="current_password">Mật Khẩu Cũ</label>
        <input type="password" id="current_password" name="current_password" placeholder="Nhập mật khẩu cũ">
        @error('current_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="new_password">Mật khẩu mới</label>
        <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
        @error('new_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="confirm_password">Nhập lại Mật khẩu mới</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
        @error('confirm_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <button type="submit" class="reset-password-btn">Xác Nhận</button>
    </form>
</main>
@endsection
