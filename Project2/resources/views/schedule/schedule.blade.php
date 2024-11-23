<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/NurserySchedule.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <main class="schedule-section py-5">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #d6336c;">Lịch trình Nursery</h2>
            
            <div class="form-group mb-3">
                <label for="classroom_id">Lớp học</label>
                <select name="classroom_id" id="classroom_id" class="form-control" required>
                    <option value="">-- Chọn lớp học --</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="date">Ngày học</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="schedule-details mt-5">
                <h3 class="text-center mb-3" style="color: #6c757d;">Chi Tiết Lịch Học</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tiết Học</th>
                            <th>Môn Học</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-details-body"></tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('classroom_id').addEventListener('change', loadSchedule);
        document.getElementById('date').addEventListener('change', loadSchedule);

        function loadSchedule() {
            const classroomId = document.getElementById('classroom_id').value;
            const date = document.getElementById('date').value;

            if (classroomId && date) {
                fetch(`/schedule/details?classroom_id=${classroomId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                const tableBody = document.getElementById('schedule-details-body');
                tableBody.innerHTML = '';
                if (data.length > 0) {
                data.forEach(item => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.subject_name}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteSchedule(${item.schedule_id}, ${item.id})">
                                Xóa
                            </button>
                        </td>
                    </tr>`;
                });
        } else {
            tableBody.innerHTML = '<tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>';
        }
    });
            }
        }
        function deleteSchedule(scheduleId, scheduleInfoId) {
            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                fetch(`/schedule/delete?schedule_id=${scheduleId}&schedule_info_id=${scheduleInfoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Xóa thành công!');
                        loadSchedule(); 
                    } else {
                        alert('Có lỗi xảy ra!');
                    }
                });
            }
        }
    </script>
</body>
</html>
