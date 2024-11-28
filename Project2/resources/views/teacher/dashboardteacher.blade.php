@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/TeacherDashboard.css') }}">
    <div class="row">
        <!-- Phần thông tin cá nhân -->
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    Thông Tin Cá Nhân
                </div>
                <div class="card-body text-center">
                    @if(Auth::check())
                        <img src="{{ asset('img/backtoschool.png/' . Auth::user()->profile_image) }}" 
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
    </div>

    <div class="row mt-4">
        <!-- Phần danh sách lớp học -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5>Danh sách Lớp Học</h5>
                </div>
                <div class="card-body">
                    <!-- Thanh tìm kiếm -->
                    <input type="text" class="form-control mb-3" placeholder="Tìm kiếm lớp học...">
                    
                    <table class="table table-bordered table-hover" id="classTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Tên</th>
                                <th>Ngày Sinh</th>
                                <th>Giới Tính</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nguyễn Văn A</td>
                                <td>25/11/2013</td>
                                <td>Nam</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="showStudentInfo('1')">
                                        <i class="fa fa-eye"></i> Xem
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Trần Thị B</td>
                                <td>15/03/2014</td>
                                <td>Nữ</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="showStudentInfo('2')">
                                        <i class="fa fa-eye"></i> Xem
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="studentInfoModal" tabindex="-1" role="dialog" aria-labelledby="studentInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentInfoModalLabel">Thông Tin Học Sinh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="studentImage" src="" alt="Ảnh Học Sinh" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                </div>
                <p><strong>Tên:</strong> <span id="studentName"></span></p>
                <p><strong>Lớp:</strong> <span id="studentClass"></span></p>
                <p><strong>Giới Tính:</strong> <span id="studentGender"></span></p>
                <p><strong>Ngày Sinh:</strong> <span id="studentBirthday"></span></p>
                <p><strong>Điểm Trung Bình:</strong> <span id="studentGrade"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Thư viện và script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle (bao gồm Popper.js và Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Dữ liệu mẫu
    const students = {
        "1": {
            name: "Nguyễn Văn A",
            class: "10A1",
            gender: "Nam",
            birthday: "25/11/2013",
            grade: "8.5",
            image: "{{ asset('img/Login.png') }}"
        },
        "2": {
            name: "Trần Thị B",
            class: "10A2",
            gender: "Nữ",
            birthday: "15/03/2014",
            grade: "9.0",
            image: "{{ asset('img/family.png') }}"
        }
    };

    function showStudentInfo(studentId) {
        const student = students[studentId];
        if (student) {
            $('#studentName').text(student.name);
            $('#studentClass').text(student.class);
            $('#studentGender').text(student.gender);
            $('#studentBirthday').text(student.birthday);
            $('#studentGrade').text(student.grade);
            $('#studentImage').attr('src', student.image);
            $('#studentInfoModal').modal('show');
        } else {
            alert('Không tìm thấy thông tin học sinh.');
        }
    }

    // Đảm bảo nút "Đóng" hoạt động
    $('#closeModalButton').click(function () {
        $('#studentInfoModal').modal('hide');
    });
</script>
@endsection
