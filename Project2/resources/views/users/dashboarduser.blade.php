@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/UserDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin cá nhân (bên trái) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Thông Tin Cá Nhân
                </div>
                <div class="card-body">
                    @if(Auth::check())
                        <img src="{{ asset('img/backtoschool.png' . Auth::user()->profile_image) }}" 
                             alt="Ảnh Đại Diện" 
                             class="rounded-circle mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">

                        <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Số Điện Thoại:</strong> {{ Auth::user()->phone }}</p>
                        <p><strong>Địa Chỉ:</strong> {{ Auth::user()->address }}</p>
                        <p><strong>Căn Cước Công Dân:</strong> {{ Auth::user()->id_number }}</p>
                        <p><strong>Giới Tính:</strong> {{ Auth::user()->gender }}</p>
                    @else
                        <p>Không có thông tin người dùng.</p>
                    @endif
                </div>
            </div>
        </div>
<<<<<<< Updated upstream
    </div>

    <div class="row mt-4">
        <!-- Phần thông báo -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    Chọn Ngày và Học Lực
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="date">Ngày:</label>
                            <input type="date" id="date" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                            <label for="hocLuc">Học Lực:</label>
                            <textarea id="hocLuc" class="form-control" rows="3" placeholder="Nhập học lực và nhận xét hôm nay"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Chọn học sinh và hiển thị thông tin -->
=======

>>>>>>> Stashed changes
        <div class="col-md-6">
            <!-- Chọn học sinh -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Chọn Học Sinh
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="student">Học Sinh:</label>
                        <select id="student" class="form-control">
                            <option value="1">Nguyễn Văn A</option>
                            <option value="2">Trần Thị B</option>
                            <option value="3">Lê Văn C</option>
                        </select>
                    </div>
                    <div class="mt-4 text-center">
                        <!-- Hiển thị ảnh học sinh -->
                        <img src="{{ asset('img/Login.png') }}" 
                             id="studentImage" 
                             alt="Ảnh Học Sinh" 
                             class="rounded mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                             
                        <h5>Thông Tin Học Sinh:</h5>
                        <p><strong>Tên:</strong> Nguyễn Văn A</p>
                        <p><strong>Lớp:</strong> 10A1</p>
                        <p><strong>Giáo Viên Chủ Nhiệm:</strong> Cô Nguyễn Thị D</p>
                        <p><strong>Điểm Trung Bình:</strong> 8.5</p>
                    </div>
                </div>
            </div>
<<<<<<< Updated upstream
        </div>
    </div>
</div>
=======

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
    <div class="row mt-4">
        <!-- Phần học lực -->
        <div class="col-md-12">
            <div class="card">
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
    </div>
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
                        let rate = '';
                        const point = Number(data.evaluation.comment); 
                        switch (true) {
                            case point >= 9:
                                rate = 'Xuất Sắc';
                                break;
                            case point >= 8:
                                rate = 'Giỏi';
                                break;
                            case point >= 6:
                                rate = 'Khá';
                                break;
                            case point >= 4:
                                rate = 'Trung Bình';
                                break;
                            case point >= 2:
                                rate = 'Yếu';
                                break;
                            default:
                                rate = 'Yếu';
                                break;
                        }
                        pointInput.value = rate || 'Chưa có dữ liệu điểm';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
});

</script>
>>>>>>> Stashed changes
@endsection
