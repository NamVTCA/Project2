@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Thông tin chính -->
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản lý tài khoản</h5>
                    <p class="card-text">Xem và chỉnh sửa thông tin tài khoản.</p>
                    <a href="#" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Quản lý lịch học</h5>
                    <p class="card-text">Tạo và sắp xếp lịch học chi tiết.</p>
                    <a href="#" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-gradient-pink text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Thống kê và báo cáo</h5>
                    <p class="card-text">Xem báo cáo chi tiết hệ thống.</p>
                    <a href="#" class="btn btn-light btn-sm">Đi tới</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Biểu đồ hoặc bảng -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-pink text-white">
                    <h5>Thống kê tổng quan</h5>
                </div>
                <div class="card-body">
                    <canvas id="dashboardChart"></canvas> <!-- Biểu đồ -->
                </div>
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


@endsection
