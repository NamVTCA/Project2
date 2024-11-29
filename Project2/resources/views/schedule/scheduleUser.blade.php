    {{-- <!DOCTYPE html>
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
                <div class="navbar-brand fw-bold fs-4" style="color: #d6336c;">LỊCH SINH HOẠT TRẺ EM</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <div class="container">
            <h2 class="text-center mb-4" style="color:#d6336c;">Lịch học Nhà trẻ</h2>
            <form class="row mb-4">
                <div class="col-md-6">
                    <label for="classroom_id" class="form-label">Lớp học</label>
                    <select name="classroom_id" id="classroom_id" class="form-select" required>
                        <option value="">-- Chọn lớp học --</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">Ngày học</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
            </form>
            <div class="schedule-details mt-4">
                <h3 class="text-center mb-3 text-secondary">Chi Tiết Lịch Học</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Tiết Học</th>
                            <th>Môn Học</th>
                        </tr>
                        </thead>
                        <tbody id="schedule-details-body">
                        <tr>
                            <td colspan="3" class="text-center text-muted">Chọn lớp và ngày học để hiển thị lịch.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
                fetch(`/api/schedule/details?classroom_id=${classroomId}&date=${date}`)
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
        </tr>`;
});
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Không có dữ liệu.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        }

       
       
    </script>
    </body>
    </html> --}}