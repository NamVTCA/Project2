@extends('layouts.dashboard')

@section('title', 'Feedback')

@section('content')
<div class="container feedback-page"> <!-- Thêm lớp feedback-page để định nghĩa phạm vi CSS -->
    <link rel="stylesheet" href="{{ asset('css/Feedback.css') }}">
    <div class="logo">
        <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool" class="logo-image">
    </div>        
    <h1>Gửi phản hồi</h1>
      @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
  @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{route('feedbackSend')}}" method="POST">
        @csrf 
        <div class="form-group">
            <label for="name">Tên của bạn</label>
            <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" required>
        </div>
        <div class="form-group">
            <label for="email">Email liên hệ</label>
            <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
        </div>
        <div class="form-group">
            <label for="message">Phản hồi</label>
            <textarea id="message" name="message" rows="5" placeholder="Nhập phản hồi của bạn" required></textarea>
        </div>
        <button type="submit" class="btn">Gửi phản hồi</button>
    </form>
</div>



<footer>
    <div class="container">
        <div class="row">
            <!-- Phần Thông Tin Trường -->
            <div class="col-md-4">
                <h6>NURSERY PRESCHOOL</h6>
                <p>Môi trường an toàn và thân thiện cho sự phát triển của trẻ.</p>
            </div>
            <!-- Phần Liên Hệ -->
            <div class="col-md-4">
                <h6>Liên hệ</h6>
                <p><strong>Địa chỉ:</strong> The Emporium Tower, 184 Đ. Lê Đại Hành, Phường 15, Quận 11, Hồ Chí Minh</p>
                <p><strong>Email:</strong> <a href="mailto:truongtruongbvn@gmail.com">truongtruongbvn@gmail.com</a></p>
                <p><strong>Phone:</strong> <a href="tel:+84123456789">+84 123 456 789</a></p>
            </div>
            <div class="col-md-4">
                <h6>Liên hệ</h6>
                <p><strong>Facebook: </strong><a href="https://www.facebook.com/vtcacademyhcm">VTCAcademy</a></p>
                <p><strong>TikTok: </strong> <a href="https://www.tiktok.com/@vtcacademy">VTCAcademy</a></p>
                <p><strong>Zalo:</strong> <a href="tel:+84123456789">+84 123 456 789</a></p>
            </div>
        </div>
        <div class="text-center">
            <p>© 2024 Nursery PreSchool. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
