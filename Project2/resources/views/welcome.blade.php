<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/NurserySchedule.css') }}">
</head>
<body>
    <!-- Header Section -->
    <header class="py-3 shadow-sm" style="background-color: #ffe4e1;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="title">NURSERY SCHEDULE</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Lịch trình</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Đăng nhập</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Schedule Section -->
    <main class="schedule-section py-5">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #d6336c;">Lịch trình Nursery</h2>
            
            <!-- Schedule Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-pink">
                        <tr>
                            <th>Thời gian</th>
                            <th>Hoạt động</th>
                            <th>Giáo viên</th>
                            <th>Ghi chú</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>08:00 - 09:00</td>
                            <td>Đón trẻ</td>
                            <td>Cô A</td>
                            <td>-</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Chỉnh sửa</button>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                        <tr>
                            <td>09:00 - 10:00</td>
                            <td>Học tập nhóm</td>
                            <td>Cô B</td>
                            <td>-</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Chỉnh sửa</button>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            
            <!-- Add Schedule Button -->
            <div class="text-center mt-4">
                <button class="btn btn-pink">Thêm lịch trình</button>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
