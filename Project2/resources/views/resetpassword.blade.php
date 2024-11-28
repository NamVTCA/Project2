<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery PreSchool - Đặt Lại Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Fogotpassword.css') }}">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-light py-3 shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="title">NURSERY PRESCHOOL</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- Nút Quay Về -->
                            <a class="nav-link btn btn-outline-primary btn-sm me-3" href="javascript:history.back();">
                                <i class="bi bi-arrow-left"></i> Quay Về
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('feedback')}}">Phản Hồi</a></li>
                        <li class="nav-item">
                            @if(Auth::check())
                                <!-- Hiển thị "Đăng Xuất" nếu người dùng đã đăng nhập -->
                                <a class="nav-link" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Đăng Xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <!-- Hiển thị "Đăng Nhập" nếu người dùng chưa đăng nhập -->
                                <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Reset Password Form -->
    <main class="reset-password-section">
        <div class="logo">
            <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool">
            <h1>Nursery PreSchool</h1>
        </div>
        @if (session('success'))
            <p class="text-success">{{session('success')}}</p>
        @endif
        <form class="reset-password-form" method="POST" action="{{route('reset.password')}}">
            @csrf
            <label for="current_password">Mật Khẩu Cũ</label>
            <input type="password" id="current_password" name="current_password" placeholder="Nhập mật khẩu cũ">
            @error('current_password')
                <p class="text-danger">{{$message}}</p>
            @enderror
            
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
            @error('new_password')
                <p class="text-danger">{{$message}}</p>
            @enderror
            
            <label for="confirm_password">Nhập lại Mật khẩu mới</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
@error('confirm_password')
                <p class="text-danger">{{$message}}</p>
            @enderror
            
            <button type="submit" class="reset-password-btn">Xác Nhận</button>
        </form>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
