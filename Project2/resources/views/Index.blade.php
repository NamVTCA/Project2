<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NURSERY PRESCHOOL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Home.css') }}">
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
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('feedback') }}">Liên Hệ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('img/backtoschool.png') }}" class="img-fluid rounded shadow" alt="Importance of Pre-School Education">
                </div>
                <div class="col-md-6">
                    <h2 class="text-primary fw-bold">Giới Thiệu Về Trường</h2>
                    <p>Ngôi trường được xây dựng như ngôi nhà thứ hai của học sinh, mang lại môi trường học tập an toàn và phát triển toàn diện.</p>
                    <a href="#" class="btn btn-primary">Thông tin trường</a>
                </div>
            </div>
        </div>
    </section>

<!-- School Information Section -->
<section class="school-info-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <!-- Đội Ngũ Giảng Dạy -->
            <div class="col-md-6 mb-4">
                <a href="link-to-teachers" class="hover-teachers text-reset text-decoration-none">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('img/family.png') }}" class="card-img-top mx-auto" alt="Teacher Icon" style="width: 50px;">
                        <div class="card-body">
                            <h3 class="card-title">Đội Ngũ Giảng Dạy</h3>
                            <p class="card-text">Bao gồm các giáo viên có chuyên môn và tận tâm chăm sóc các em.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Mục Tiêu -->
            <div class="col-md-6 mb-4">
                <a href="link-to-goals" class="hover-goals text-reset text-decoration-none">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('img/tam.png') }}" class="card-img-top mx-auto" alt="Goal Icon" style="width: 50px;">
                        <div class="card-body">
                            <h3 class="card-title">Mục Tiêu</h3>
                            <p class="card-text">Mang đến cho các em một môi trường học tập tốt nhất.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>


    <!-- Footer Section -->
    <footer class="bg-light text-center text-muted py-4">
        <div class="container">
            <div class="row">
                <!-- School Info -->
                <div class="col-md-4">
                    <h6 class="text-uppercase fw-bold mb-4">NURSERY PRESCHOOL</h6>
                    <p>Môi trường an toàn và thân thiện cho sự phát triển của trẻ.</p>
                </div>
                <!-- Quick Links -->
                {{-- <div class="col-md-4">
                    <h6 class="text-uppercase fw-bold mb-4">Liên Kết Nhanh</h6>
                    <p><a href="#" class="text-reset">Home</a></p>
                    <p><a href="#" class="text-reset">News</a></p>
                    <p><a href="#" class="text-reset">Education</a></p>
                    <p><a href="#" class="text-reset">Contact</a></p>
                </div> --}}
                <!-- Contact Info -->
                <div class="col-md-4">
                    <h6 class="text-uppercase fw-bold mb-4">Liên Hệ</h6>
                    <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP HCM</p>
                    <p>Email: email@example.com</p>
                    <p>Phone: +84 123 456 789</p>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-light text-muted">
            © 2024 Nursery PreSchool. All rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
