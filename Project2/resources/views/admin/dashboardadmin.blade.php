@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Admin.css') }}">
<div class="container-fluid py-4">
    <div class="row">
        <!-- Thông tin chính -->
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản lý tài khoản</h5>
                    <p class="card-text">Xem và chỉnh sửa thông tin tài khoản.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản lý lịch học</h5>
                    <p class="card-text">Tạo và sắp xếp lịch học chi tiết.</p>
                    <a href="{{ route('timetable') }}" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Phản Hồi</h5>
                    <p class="card-text">Xem chi tiết các phản hồi.</p>
                    <a href="{{ route('feedback.index') }}" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản lý học sinh</h5>
                    <p class="card-text">Xem và chỉnh sửa thông tin học sinh.</p>
                    <a href="{{ route('admin.children.index') }}" class="btn btn-light btn-sm">Đi tới</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm bg-gradient-pink text-white text-center">
            <div class="card-body">
                <h5 class="card-title"> Quản lý học phí</h5>
                <p class="card-text">Xem và chỉnh sửa học phí.</p>
                <a href="{{ route('tuitionmanagement') }}" class="btn btn-light btn-sm">Đi tới</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm bg-gradient-pink text-white text-center">
            <div class="card-body">
                <h5 class="card-title"> Quản lý Lớp Học</h5>
                <p class="card-text">Xem và chỉnh sửa lớp học.</p>
                <a href="{{ route('admin.classrooms.index') }}" class="btn btn-light btn-sm">Đi tới</a>
            </div>
        </div>
    </div>

    {{-- <div class="row mt-4">
        <!-- Biểu đồ hoặc bảng -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-pink text-black">
                    <h5>Thống kê tổng quan</h5>
                </div>
                <div class="card-body">
                    <canvas id="dashboardChart"></canvas> <!-- Biểu đồ -->
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
            datasets: [{
                label: 'Số lượng học sinh mới',
                data: [12, 19, 3, 5],
                backgroundColor: 'rgba(255, 105, 180, 0.7)',
                borderColor: 'rgba(255, 105, 180, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
 --}}
 <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
    <label for="month">Chọn tháng:</label>
    <select name="month" id="month" class="form-control d-inline-block w-auto">
        <option value="">Tất cả</option>
        @for ($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                Tháng {{ $i }}
            </option>
        @endfor
    </select>
    <button type="submit" class="btn btn-primary">Lọc</button>
</form>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-pink text-black">
                <h5>Thống kê tổng quan</h5>
            </div>
            <div class="card-body">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_column($statistics->toArray(), 'month')),
            datasets: [
                {
                    label: 'Tổng số học sinh',
                    data: @json(array_column($statistics->toArray(), 'total_students')),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Học sinh mới',
                    data: @json(array_column($newStudents->toArray(), 'new_students')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Giáo viên mới',
                    data: @json(array_column($newTeachers->toArray(), 'new_teachers')),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Phụ huynh mới',
                    data: @json(array_column($newParents->toArray(), 'new_parents')),
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Phản hồi nhận được',
                    data: @json(array_column($feedbacks->toArray(), 'total_feedbacks')),
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
