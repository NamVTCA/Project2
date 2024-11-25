@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Tạo người dùng mới</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Họ tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   pattern="^[\pL\s]+$"
                   oninvalid="this.setCustomValidity('Họ tên chỉ được chứa chữ cái và khoảng trắng')"
                   oninput="this.setCustomValidity('')"
                   required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                   oninvalid="this.setCustomValidity('Vui lòng nhập email hợp lệ (ví dụ: example@domain.com)')"
                   oninput="this.setCustomValidity('')"
                   required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Mật khẩu:</label>
            <input type="text" name="password" minlength="6"
                   oninvalid="this.setCustomValidity('Mật khẩu phải có ít nhất 6 ký tự')"
                   oninput="this.setCustomValidity('')"
                   required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>CMND/CCCD:</label>
            <input type="text" name="id_number" value="{{ old('id_number') }}"
                   pattern="^[0-9\s]+$"
                   oninvalid="this.setCustomValidity('CMND/CCCD chỉ được chứa số và khoảng trắng')"
                   oninput="this.setCustomValidity('')"
                   required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Địa chỉ:</label>
            <input type="text" name="address" value="{{ old('address') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Vai trò:</label>
            <select name="role" required>
                <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Giáo viên</option>
                <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Phụ huynh</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Trạng thái:</label>
            <select name="status" required>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

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
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const errorSpan = this.nextElementSibling;
            
            if (this.validity.valid) {
                errorSpan.textContent = '';
            } else {
                switch(this.name) {
                    case 'name':
                        errorSpan.textContent = 'Họ tên chỉ được chứa chữ cái và khoảng trắng';
                        break;
                    case 'email':
                        errorSpan.textContent = 'Vui lòng nhập email hợp lệ';
                        break;
                    case 'password':
                        errorSpan.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
                        break;
                    case 'id_number':
                        errorSpan.textContent = 'CMND/CCCD chỉ được chứa số và khoảng trắng';
                        break;
                    case 'phone':
                        errorSpan.textContent = 'Số điện thoại chỉ được chứa số và khoảng trắng';
                        break;
                }
            }
        });
    });
});
</script>

<style>
.error-message {
    color: red;
    font-size: 0.8em;
    display: block;
    margin-top: 5px;
}
</style>
@endsection