@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>Quản lý Lớp Học</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Thống kê -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5>Thống kê tổng quan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="dashboardChart"></canvas> <!-- Biểu đồ -->
                        </div>
                    </div>
                </div>

                <!-- Danh sách lớp học -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5>Danh sách Lớp Học</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên Lớp</th>
                                        <th>Sĩ Số</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dữ liệu mẫu -->
                                    <tr>
                                        <td>1</td>
                                        <td>Lớp Mầm Non A</td>
                                        <td>25</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">Xem</a>
                                            <a href="#" class="btn btn-sm btn-danger">Xóa</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Lớp Mầm Non B</td>
                                        <td>30</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">Xem</a>
                                            <a href="#" class="btn btn-sm btn-danger">Xóa</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hoạt động gần đây -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5>Hoạt động gần đây</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Thêm mới học sinh vào lớp Mầm Non A</li>
                                <li class="list-group-item">Cập nhật sĩ số lớp Mầm Non B</li>
                                <li class="list-group-item">Thêm bài giảng mới cho lớp Mầm Non A</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm các script cần thiết -->
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
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Biểu đồ Thống kê học sinh'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection