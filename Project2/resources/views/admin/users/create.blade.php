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
            @if(isset($user) && $user->img)
                <div style="margin: 10px 0;">
                    <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" id="profileImage" name="img" accept="image/*" class="form-control">
        </div>

        <!-- Các trường nhập liệu -->
        <div class="form-group mb-3">
            <label for="name">Họ tên:</label>

            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"value="{{ old('name', $user->name ?? '') }}"onkeypress="return /[a-zA-Z\s]/i.test(event.key)"required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
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
            <input type="text" id="id_number" name="id_number" class="form-control @error('id_number') is-invalid @enderror"value="{{ old('id_number', $user->id_number ?? '') }}"onkeypress="return /[0-9]/i.test(event.key)"maxlength="12"required>
                @error('id_number')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
        </div>

        <div class="form-group mb-3">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
            <input type="text" 
                       name="phone"
                       id="phone" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone') }}" 
                       pattern="[0-9]{10,11}"
                       onkeypress="return /[0-9]/i.test(event.key)"
                       maxlength="11"
                       required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group mb-3">
            <label for="role">Vai trò:</label>
            <select id="role" name="role" class="form-control" required>
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
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="name"]');
        if (nameInput) {
            nameInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        }
    
        const idNumberInput = document.querySelector('input[name="id_number"]');
        if (idNumberInput) {
            idNumberInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
    </script>   
@endsection
