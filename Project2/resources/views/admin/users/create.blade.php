@extends('layouts.dashboard')

@section('title', 'Quản lý tài khoản')

@section('content')
<link rel="stylesheet" href="{{ asset('css/AccountCreation.css') }}">
<div class="user-creation-section">
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

            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            <span class="invalid-feedback" id="name-error"></span>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            <span class="invalid-feedback" id="email-error"></span>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="password">Mật khẩu:</label>
            <input type="text" id="password" name="password" class="form-control" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="id_number">Số căn cước công dân:</label>
            <input type="text" id="id_number" name="id_number" class="form-control @error('id_number') is-invalid @enderror" value="{{ old('id_number', $user->id_number ?? '') }}" maxlength="12" required>
            <span class="invalid-feedback" id="id-number-error"></span>
            @error('id_number')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
            @error('address')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" maxlength="11" required>
            <span class="invalid-feedback" id="phone-error"></span>
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
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="1">Hoạt động</option>
                <option value="0">Không hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (!this.validity.valid) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });

        const nameInput = document.getElementById('name');
        const nameError = document.getElementById('name-error');

        nameInput.addEventListener('input', function() {
            const namePattern = /^[\p{L}\s]+$/u;
            if (!namePattern.test(this.value)) {
                nameError.textContent = 'Vui lòng nhập tên hợp lệ (chỉ chứa chữ cái và khoảng trắng)';
                this.classList.add('is-invalid');
            } else {
                nameError.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');

        emailInput.addEventListener('input', function() {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(this.value)) {
                emailError.textContent = 'Vui lòng nhập email hợp lệ';
                this.classList.add('is-invalid');
            } else {
                emailError.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        const idNumberInput = document.getElementById('id_number');
        const idNumberError = document.getElementById('id-number-error');

        idNumberInput.addEventListener('input', function() {
            const idNumberPattern = /^[0-9]{1,12}$/;
            if (!idNumberPattern.test(this.value)) {
                idNumberError.textContent = 'Vui lòng nhập số căn cước công dân hợp lệ (chỉ chứa số, tối đa 12 ký tự)';
                this.classList.add('is-invalid');
            } else {
                idNumberError.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phone-error');

        phoneInput.addEventListener('input', function() {
            const phonePattern = /^[0-9]{1,11}$/;
            if (!phonePattern.test(this.value)) {
                phoneError.textContent = 'Vui lòng nhập số điện thoại hợp lệ (chỉ chứa số, tối đa 11 ký tự)';
                this.classList.add('is-invalid');
            } else {
                phoneError.textContent = '';
                this.classList.remove('is-invalid');
            }
        });
    });
</script>   
@endsection