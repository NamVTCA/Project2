@extends('layouts.dashboard')

@section('content')

<main class="login-section">
    <link rel="stylesheet" href="{{ asset('css/Login.css') }}">
    <div class="logo">
        <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool">
        <h1>Nursery PreSchool</h1>
    </div>
    
    <form class="login-form" action="{{ route('login') }}" method="post">
        @csrf
        @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
        <label for="phone">Tài khoản (Email hoặc SĐT)</label>
        <input type="text" id="phone" name="phone" placeholder="*****">
        
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" placeholder="******">
        
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        
        <button type="submit" class="login-btn">Đăng nhập</button>
        
        <a href="{{ route('showfogot') }}" class="forgot-password">Quên Mật Khẩu</a>
        <p class="note">Lưu ý: <span>Hãy sử dụng tài khoản nhà trường cung cấp</span></p>
        
        @if (session('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif
    </form>
</main>
@endsection
