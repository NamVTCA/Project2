<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NURSERY PRRSCHOOL - Đặt Lại Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ResetPassword.css') }}">
</head>
<body>
    <!-- Header Section -->
    <header class="py-3 shadow-sm" style="background-color: #ffe4e1;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="title">NURSERY PRESCHOOL</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">Trang Chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Liên Hệ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Đăng Nhập</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Reset Password Form -->
    <main class="reset-password-section">
        <div class="logo">
        <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool">
        <h1>NURSERY PRRSCHOOL</h1>
        </div>

        <form action="{{ route('otp') }}" method="get" class="send-otp-form">
        @csrf
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required  >
        <button type="submit" class="btn btn-primary">Gửi mã xác nhận</button>
        </form>

        <form action="{{route('resetPassword')}}" method="get" class="reset-password-form">
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại">
            <label for="otp">Mã xác nhận</label>
            <input type="text" id="otp" name="otp" placeholder="Nhập mã xác nhận">
            <label for="new-password">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
            <label for="confirm-password">Nhập lại Mật khẩu mới</label>
            <input type="password" id="confirm_password"name="confirm_password"  placeholder="Nhập lại mật khẩu mới">
            
            <button type="submit" class="reset-password-btn">Đặt lại mật khẩu</button>
        </form>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
