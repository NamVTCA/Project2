@extends('layouts.dashboard')

@section('title', 'Quản lý tài khoản')

@section('content')
<div class="container mt-4">
    <h2>Tạo người dùng mới và cấp tài khoản</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Phần tải lên ảnh đại diện -->
        <div class="form-group mb-3">
            <label for="profileImage">Ảnh đại diện 3x4</label>
            <input type="file" id="profileImage" name="img" accept="image/*" class="form-control">
        </div>

        <!-- Các trường nhập liệu -->
        <div class="form-group mb-3">
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="id_number">Số căn cước công dân:</label>
            <input type="text" id="id_number" name="id_number" class="form-control" value="{{ old('id_number') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="role">Vai trò:</label>
            <select id="role" name="role" class="form-control" required>
                <option value="0">Admin</option>
                <option value="1">Giáo Viên</option>
                <option value="2">Phụ Huynh</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" class="form-control" required>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="1">Hoạt động</option>
                <option value="0">Không hoạt động</option>
            </select>
        </div>

<<<<<<< Updated upstream
        <div style="margin-bottom: 15px;">
            <label>Số điện thoại:</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   pattern="^[0-9\s]+$"
                   oninvalid="this.setCustomValidity('Số điện thoại chỉ được chứa số và khoảng trắng')"
                   oninput="this.setCustomValidity('')"
                   required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh đại diện:</label>
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
        </div>

        <button type="submit">Tạo người dùng</button>
=======
        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
>>>>>>> Stashed changes
    </form>
</div>
@endsection
