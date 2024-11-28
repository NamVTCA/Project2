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



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


@endsection
