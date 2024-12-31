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
        <label for="current_password">Mật khẩu cũ</label>
        <div class="password-container">
            <input type="password" id="current_password" name="current_password" placeholder="Nhập mật khẩu cũ">
            <span class="toggle-password" onclick="togglePasswordVisibility('current_password')">👁️</span>
        </div>
        @error('current_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="new_password">Mật khẩu mới</label>
        <div class="password-container">
            <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
            <span class="toggle-password" onclick="togglePasswordVisibility('new_password')">👁️</span>
        </div>
        @error('new_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="confirm_password">Nhập lại mật khẩu mới</label>
        <div class="password-container">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
            <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">👁️</span>
        </div>
        @error('confirm_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        <button type="submit" class="reset-password-btn">Xác nhận</button>
    </form>    
</main>

<script>
    function togglePasswordVisibility(passwordId) {
        var passwordField = document.getElementById(passwordId);
        var icon = passwordField.nextElementSibling;

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.innerHTML = "🙈"; // Đổi biểu tượng mắt thành "ẩn"
        } else {
            passwordField.type = "password";
            icon.innerHTML = "👁️"; // Đổi lại biểu tượng mắt
        }
    }
</script>
@endsection
