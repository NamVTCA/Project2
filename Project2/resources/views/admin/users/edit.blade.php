@extends('layouts.dashboard')

@section('content')
<div>
    <link rel="stylesheet" href="{{ asset('css/AccountEdit.css') }}">
    <h2>Chỉnh sửa thông tin người dùng</h2>
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($user->role == 0)
        <div style="color: red;">403 | Bạn không có quyền truy cập trang này.</div>
    @else
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            <span class="invalid-feedback" id="name-error"></span>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            <span class="invalid-feedback" id="email-error"></span>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px; position: relative;">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control">
            <small>Để trống nếu bạn không muốn thay đổi mật khẩu.</small>
            <span id="toggle-password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                👁️
            </span>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>        

        <div style="margin-bottom: 15px;">
            <label for="id_number">Số căn cước công dân:</label>
            <input type="text" id="id_number" name="id_number" class="form-control @error('id_number') is-invalid @enderror" value="{{ old('id_number', $user->id_number) }}" maxlength="12" required>
            <span class="invalid-feedback" id="id-number-error"></span>
            @error('id_number')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}" required>
            @error('address')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" maxlength="11" required>
            <span class="invalid-feedback" id="phone-error"></span>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>       

        <div style="margin-bottom: 15px;">
            <label for="role">Vai trò:</label>
            <select id="role" name="role" class="form-control" required>
                <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Giáo viên</option>
                <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Phụ huynh</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender" class="form-control" required>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh đại diện:</label>
            @if(isset($user) && $user->img)
                <div style="margin: 10px 0;">
                    <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
            <small style="color: #666;">Để trống nếu không muốn thay đổi ảnh</small>
        </div>      
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    @endif
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
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Kiểm tra trạng thái hiện tại của trường mật khẩu
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Đổi biểu tượng con mắt
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    });

            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>   
@endsection