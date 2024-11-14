<!DOCTYPE html>
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
    <header class="py-3 shadow-sm" style="background-color: #ffe4e1;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="title">NURSERY PRRSCHOOL</div>
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
                
                <button type="submit" class="account-creation-btn">Xong</button>
            </div>
        </form>
    </main>

    <script src="{{ asset('js/AccountCreation.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
