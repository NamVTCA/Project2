@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/TeacherDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin cá nhân -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    Thông Tin Cá Nhân
                </div>
                <div class="card-body text-center">
                    @if(Auth::check())
                        <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('img/default_avatar.png') }}" alt="Ảnh Đại Diện" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ Auth::user()->phone }}</p>
                        <p><strong>Địa Chỉ:</strong> {{ Auth::user()->address }}</p>
                        <p><strong>Căn Cước Công Dân:</strong> {{ Auth::user()->id_number }}</p>
                        <p><strong>Giới Tính:</strong> {{ Auth::user()->gender }}</p>
                        <p><strong>Lớp Dạy:</strong> {{ Auth::user()->classroom->name }}</p>
                    @else
                        <p>Không có thông tin người dùng.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Phần form gộp 3 phần -->
        <div class="col-md-6">
            <form class="card">
                <div class="card-header bg-primary text-white text-center">
                    Quản Lý Hoạt Động
                </div>
                <div class="card-body">
                    <!-- Thanh Toán Và Quản Lý Học Phí -->
                    <div class="form-group">
                        <label for="tuitionManagement">Quản Lý Học Phí:</label>
                        <div>
                            <a href="{{ route('momo') }}" class="btn btn-light btn-sm">Thanh Toán</a>
                        </div>
                    </div>

                    <!-- Đánh Giá -->
                    <div class="form-group">
                        <label for="evaluation">Đánh Giá:</label>
                        <div>
                            <a href="{{ route('evaluate') }}" class="btn btn-light btn-sm">Đánh Giá</a>
                        </div>
                    </div>
                    
                    <!-- Quản Lý Lịch Học -->
                    <div class="form-group">
                        <label for="scheduleManagement">Quản Lý Lịch Học:</label>
                        <div>
                            <a href="{{ route('schedule.create') }}" class="btn btn-light btn-sm">Tạo</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5>Danh sách Lớp Học</h5>
                </div>
                <div class="card-body">
                    @if($students->isEmpty())
                        <p>Không có học sinh nào trong lớp.</p>
                    @else
                        <table class="table table-bordered table-hover" id="classTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Tên</th>
                                    <th>Ngày Sinh</th>
                                    <th>Giới Tính</th>
                                    <th>Phụ Huynh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->birthDate }}</td>
                                        <td>{{ ($student->gender)  === 1 ? 'Nam' : 'Nữ'; }}</td>
                                        <td>{{ $student->user->name ?? 'Không có thông tin' }}</td>                                      
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Bên trái: Chọn ngày và học lực -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    Chọn Ngày và Học Lực
                </div>
                <div class="card-body">
                    <form id="evaluation-form">
                        <div class="form-group">
                            <label for="date">Ngày:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="point">Học Lực:</label>
                            <input type="text" id="point" name="point" class="form-control" disabled>
                        </div>
                        <div class="form-group mt-3">
                            <label for="hocLuc">Đánh Giá</label>
                            <textarea disabled id="hocLuc" class="form-control" rows="3" placeholder="Nhận xét học lực"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bên phải: Chọn học sinh và chi tiết học sinh -->
        <div class="col-md-6">
            <!-- Chọn học sinh -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Chọn Học Sinh
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="child_id">Học Sinh:</label>
                        <select name="child_id" id="child_id" class="form-select" required>
                            <option value="" disabled selected>-- Chọn học sinh --</option>
                            @foreach($children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Chi tiết học sinh -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    Chi Tiết Học Sinh
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong> <span id="student-name"></span></p>
                    <p><strong>Ngày Sinh:</strong> <span id="student-birth"></span></p>
                    <p><strong>Giới Tính:</strong> <span id="student-gender"></span></p>
                    <p><strong>Lớp:</strong> <span id="student-class"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const studentSelect = document.getElementById('child_id');
        const dateInput = document.getElementById('date');
        const pointInput = document.getElementById('point');
        const studentName = document.getElementById('student-name');
        const studentBirth = document.getElementById('student-birth');
        const studentGender = document.getElementById('student-gender');
        const studentClass = document.getElementById('student-class');
        const hocLuc = document.getElementById('hocLuc');
        studentSelect.addEventListener('change', fetchStudentDetails);
        dateInput.addEventListener('change', fetchStudentDetails);
    
        function fetchStudentDetails() {
            const childId = studentSelect.value;
            const date = dateInput.value;
    
            if (childId && date) {
               fetch(`/api/student/details?child_id=${childId}&date=${date}`)
    
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            studentName.textContent = data.student.name;
                            studentBirth.textContent = data.student.birthDate;
                            studentGender.textContent = data.student.gender === 1 ? 'Nam' : 'Nữ';
                            studentClass.textContent = data.student.className || 'Chưa xác định';
                            hocLuc.value = data.evaluation.comment || 'Chưa có dữ liệu học lực';
                            const point = data.evaluation.point;
    let rate;
    
    if (point == 10) {
        rate = 'Xuất Sắc';
    } else if (point == 8) {
        rate = 'Giỏi';
    } else if (point == 6) {
        rate = 'Khá';
    } else if (point == 4) {
        rate = 'Trung Bình';
    } else if (point == 2) {
        rate = 'Yếu';
    } else {
        rate = 'Chưa có dữ liệu điểm';
    }
                            pointInput.value = rate;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    });
    </script>
@endsection
