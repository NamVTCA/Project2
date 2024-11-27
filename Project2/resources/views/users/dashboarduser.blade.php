@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/UserDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin cá nhân căn giữa -->
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    Thông Tin Cá Nhân
                </div>
                <div class="card-body text-center">
                    @if(Auth::check())
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
    </div>

  <div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/UserDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin học sinh -->
        <div class="col-md-6">
            <div class="card">
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
        </div>
        <!-- Phần thông tin chi tiết -->
        <div class="col-md-6">
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
                            <label for="hocLuc">Đánh giá:</label>
                            <textarea disabled id="hocLuc" class="form-control" rows="3" placeholder="Nhận xét học lực"></textarea>
                        </div>
                    </form>
                </div>
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

    // Fetch student details when selection changes
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
                           switch (data.evaluation.point) {
                             case 10:
                            rate = 'Xuất Sắc'
                                break;
                            case 8:
                            rate = 'Giỏi'
                                break;
                            case 6:
                            rate = 'Khá'
                                break;
                            case 4:
                            rate = 'Trung Bình'
                                break;
                            case 2:
                            rate = 'Yếu'
                                break;
                            default:rate = 'Yếu'
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

</div>
@endsection
