<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý trường mẫu giáo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .alert {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        /* Nút Quay Về */
.nav-link.btn.btn-outline-primary.btn-sm.me-3 {
    display: inline-block;
    color: #fff; /* Màu chữ trắng */
    background-color: #f27eec; /* Màu xanh Bootstrap */
    padding: 8px 16px; /* Khoảng cách bên trong */
    font-size: 14px; /* Kích thước chữ */
    font-weight: 500; /* Đậm hơn một chút */
    border-radius: 5px; /* Bo góc */
    text-decoration: none; /* Xóa gạch chân */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Hiệu ứng hover */
}

.nav-link.btn.btn-outline-primary.btn-sm.me-3:hover {
    background-color: #fa03d5; /* Màu xanh đậm hơn khi hover */
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
}

.nav-link.btn.btn-outline-primary.btn-sm.me-3:active {
    background-color: #f90bd9; /* Màu khi bấm giữ */
    transform: scale(0.95); /* Thu nhỏ nhẹ khi nhấn */
}
    </style>
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

    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
        document.addEventListener('DOMContentLoaded', function() 
        {
            const fullnameInput = document.querySelector('input[name="fullname"]');
            if(fullnameInput) 
            {
                fullnameInput.addEventListener('input', function(e) 
                {
                    if(!/^[A-Za-z\s]*$/.test(this.value)) 
                    {
                        this.value = this.value.replace(/[^A-Za-z\s]/g, '');
                    }
                });
            }

            const numericInputs = document.querySelectorAll('input[name="phone"], input[name="idnumber"]');
            numericInputs.forEach(input => 
            {
                input.addEventListener('input', function(e) 
                {
                    if(!/^\d*$/.test(this.value)) 
                    {
                        this.value = this.value.replace(/\D/g, '');
                    }
                });
            });
        });
    </script>
</body>
</html>
