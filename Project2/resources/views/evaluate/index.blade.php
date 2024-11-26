<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch học mẫu giáo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/NurserySchedule.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<header class="py-3 shadow-sm" style="background-color:#ffe4e1;">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="navbar-brand fw-bold fs-4" style="color: #d6336c;">đánh giá theo ngày</div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Thành phần</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Giáo dục</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ Route('login') }}">Đăng Nhập</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<main class="schedule-section py-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color:#d6336c;">đánh giá theo ngày</h2>
        <form class="row mb-4" action="{{route('evaluate')}}" method="post">
            @csrf   
            <div class="col-md-6">
                <label for="child_id" class="form-label">học sinh</label>
                <select name="child_id" id="child_id" class="form-select" required>
                    <option value="">-- Chọn học sinh --</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Ngày học</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
              <div class="col-md-12">
                <label for="comment" class="form-label">nhận xét</label>
                <input type="text" name="comment" id="comment" max="255">
            </div>
             </div>
              <div class="col-md-12">
                <label for="point" class="form-label">Đánh Giá</label>
                <select name="point" id="point">
                <option value="" disabled selected>Đánh Giá</option>
                <option value="10">Xuất Sắc</option>
                <option value="8">Giỏi</option>
                <option value="6">Khá</option>
                <option value="4">Trung Bình</option>
                <option value="2">Yếu</option>
                </select>
            </div>
            <div class="col-md-12">
                <button type="submit">submit</button>
            </div>
        </form>
    
    </div>
</main>