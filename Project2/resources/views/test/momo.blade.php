<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Học Phí</title>
    <!-- Link tới Bootstrap và file CSS riêng -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Payment.css') }}"> <!-- Link đến CSS riêng -->
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
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Liên Hệ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Payment Form -->
    <div class="container my-5">
        <h2 class="text-center text-pink">Thanh Toán Học Phí</h2>
        <form action="{{route('momo_payment')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tuition_id" class="form-label text-pink">Chọn kỳ học phí</label>
                <select class="form-select" id="tuition_id" name="tuition_id" required>
                    @foreach ($tuitions as $tuition)
                        @if ($tuition->status === 0)
                            <option value="{{ $tuition->id }}">
                                Học phí kỳ {{ $tuition->semester }} - {{ number_format($tuition->tuition_info->sum('price')) }} VNĐ
                            </option>
                        @else
                            <option value="{{ $tuition->id }}" disabled>
                                Học phí kỳ {{ $tuition->semester }} - {{ number_format($tuition->tuition_info->sum('price')) }} VNĐ (Đã thanh toán)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-pink w-100">Thanh Toán</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
