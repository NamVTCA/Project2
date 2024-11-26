<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh Giá Theo Ngày</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/EvaluateIndex.css"> <!-- Kết nối file CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<header class="py-3 shadow-sm bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="title">NURSERY PRESCHOOL</div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
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

<main class="schedule-section py-5">
    <div class="container bg-light">
        <h2 class="text-pink">Đánh Giá Theo Ngày</h2>
        <form action="{{route('evaluate')}}" method="post" class="row">
            @csrf
            <div class="col-md-6 mb-3">
                <label for="child_id" class="form-label">Học Sinh</label>
                <select name="child_id" id="child_id" class="form-select" required>
                    <option value="" disabled selected>-- Chọn học sinh --</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Ngày Học</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="comment" class="form-label">Nhận Xét</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" maxlength="255"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <label for="point" class="form-label">Đánh Giá</label>
                <select name="point" id="point" class="form-select">
                    <option value="" disabled selected>Chọn Đánh Giá</option>
                    <option value="10">Xuất Sắc</option>
                    <option value="8">Giỏi</option>
                    <option value="6">Khá</option>
                    <option value="4">Trung Bình</option>
                    <option value="2">Yếu</option>
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-pink">Gửi Đánh Giá</button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
