<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NURSERY PRESCHOOL - Đặt Lại Mật Khẩu</title>
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
            <h1>NURSERY PRESCHOOL</h1>
        </div>

        <!-- Form gửi OTP -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gửi mã OTP
        document.getElementById('sendOtpForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngừng gửi form theo cách truyền thống

    const phone = document.getElementById('phone').value;

    // Kiểm tra sự tồn tại của thẻ <meta name="csrf-token">
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) {
        console.error('CSRF token meta tag not found');
        return;
    }

    const csrfToken = csrfTokenMeta.getAttribute('content');

    // Kiểm tra xem số điện thoại có trống không
    if (!phone) {
        alert('Vui lòng nhập số điện thoại!');
        return;
    }

    // Gửi request AJAX với phương thức GET
    fetch("{{ route('otp') }}?phone=" + encodeURIComponent(phone), {
        method: 'GET',  // Sử dụng phương thức GET
        headers: {
            'X-CSRF-TOKEN': csrfToken // Thêm CSRF token nếu cần thiết
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('resetMessage').innerHTML = '<div class="alert alert-success">Mã xác nhận đã được gửi thành công!</div>';
        } else {
            document.getElementById('resetMessage').innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    })
    .catch(error => {
        document.getElementById('resetMessage').innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại.</div>';
        console.error('Error:', error);  // Kiểm tra lỗi nếu có
    });
});
    </script>
</body>
</html>
