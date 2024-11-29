{{-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery PreSchool - Cấp Tài Khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/AccountCreation.css') }}">
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

    <!-- Account Creation Form -->
    <main class="account-creation-section">
        <h2>Cấp tài khoản</h2>
        <form class="account-creation-form d-flex">
            <!-- Phần tải lên ảnh bên trái -->
            <div class="image-upload">
                <label for="profileImage">
                    <div class="upload-area">
                        <span>Thêm ảnh 3x4</span>
                        <input type="file" id="profileImage" accept="image/*" style="display: none;">
                    </div>
                </label>
                <div class="upload-buttons">
                    <button type="button" class="confirm-btn">Xác nhận</button>
                    <button type="button" class="cancel-btn">Hủy</button>
                </div>
            </div>
            
            <!-- Các trường nhập liệu bên phải -->
            <div class="form-fields">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" placeholder="Nhập số điện thoại">
                
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Nhập email">
                
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" placeholder="Nhập họ và tên">
                
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" placeholder="Nhập địa chỉ">
                
                <label for="citizen-id">Số căn cước công dân</label>
                <input type="text" id="citizen-id" placeholder="Nhập số căn cước công dân">

                <label for="role">Quyền</label>
                <select id="role" name="role" class="form-control">
                    <option value=0>Admin</option>
                    <option value="1">Giáo Viên</option>
                    <option value="2">Phụ Huynh</option>
                </select>
                
                <label for="gender">Giới tính</label>
                <select id="gender" name="gender" class="form-control">
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                </select>
                

                <button type="submit" class="account-creation-btn">Xong</button>
            </div>
        </form>
    </main>

    <script src="{{ asset('js/AccountCreation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}
