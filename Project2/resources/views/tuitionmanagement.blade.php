<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Học Phí</title>
    <link rel="stylesheet" href="{{ asset('css/TuitionManagement.css') }}">
</head>
<body>
    <div class="container">
        <h1>Quản Lý Học Phí</h1>

        <div class="actions">
            <a href="{{ route('tuition.create') }}" class="btn">Tạo Học Phí</a>
        </div>

        <table class="tuition-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lớp</th>
                    <th>Học Kỳ</th>
                    <th>Trạng Thái</th>
                    <th>Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Lớp 1A</td>
                    <td>Học kỳ 1</td>
                    <td>Chưa Thanh Toán</td>
                    <td><a href="#" class="btn">Xem Chi Tiết</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Lớp 2B</td>
                    <td>Học kỳ 2</td>
                    <td>Đã Thanh Toán</td>
                    <td><a href="#" class="btn">Xem Chi Tiết</a></td>
                </tr>
                <!-- Dữ liệu mẫu -->
                <tr>
                    <td>3</td>
                    <td>Lớp 3C</td>
                    <td>Học kỳ 1</td>
                    <td>Chưa Thanh Toán</td>
                    <td><a href="#" class="btn">Xem Chi Tiết</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
