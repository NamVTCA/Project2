<!-- resources/views/tuitionmanagement.blade.php -->
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
                <!-- Duyệt qua danh sách học phí -->
                @foreach ($tuitions as $tuition)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tuition->classroom->name ?? 'N/A' }}</td>
                        <td>{{ $tuition->semester }}</td>
                        <td>{{ $tuition->status == 1 ? 'Đã Thanh Toán' : 'Chưa Thanh Toán' }}</td>
                        <td><a href="{{ route('tuition.show', $tuition->id) }}" class="btn">Xem Chi Tiết</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nếu có thông báo thành công -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

</body>
</html>
