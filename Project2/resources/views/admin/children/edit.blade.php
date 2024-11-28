@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ChildrenEdit.css') }}">

<div class="edit-student-wrapper">
    <form action="{{ route('children.update', $child->id) }}" method="PUT" enctype="multipart/form-data" id="childForm">
        <h2>Chỉnh sửa thông tin học sinh</h2>
        @csrf
        @method('PUT')

        <div>
            <label>Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                pattern="^[\p{L}\s]+$" 
                title="Tên chỉ được chứa chữ cái và khoảng trắng" 
                oninput="validateName(this)">
            <span class="error-message" style="display: none;">Vui lòng nhập tên hợp lệ (chỉ chứa chữ cái và khoảng trắng).</span>
        </div>

        <div>
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" max="{{ date('Y-m-d') }}" required>
        </div>

        <div>
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender', $child->gender) == 1 ? 'selected' : '' }}>Nam</option>
                <option value="2" {{ old('gender', $child->gender) == 2 ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div>
            <label>Phụ huynh:</label>
            <select name="user_id" required>
                @php
                    $parents = App\Models\User::where('role', 2)->get();
                @endphp
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('user_id', $child->user_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Trạng thái:</label>
            <select name="status" required>
                <option value="1" {{ old('status', $child->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $child->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div>
            <label>Ảnh đại diện:</label>
            @if(isset($user) && $user->img)
                <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image">
            @endif
            <input type="file" name="img" accept="image/*">
        </div>

        <button type="submit">Cập nhật thông tin học sinh</button>
    </form>
</div>

<script>
    // Validate tên
    function validateName(input) {
        const pattern = /^[\p{L}\s]+$/u; // Hỗ trợ ký tự Unicode
        const errorMessage = input.nextElementSibling; // Tìm span.error-message đi kèm
        if (!pattern.test(input.value)) {
            errorMessage.style.display = 'block'; // Hiển thị lỗi
            input.setCustomValidity('Tên chỉ được chứa chữ cái và khoảng trắng');
        } else {
            errorMessage.style.display = 'none'; // Ẩn lỗi
            input.setCustomValidity(''); // Xóa lỗi
        }
    }

    // Thêm sự kiện submit cho form để kiểm tra trước khi gửi
    document.getElementById('childForm').addEventListener('submit', function (e) {
        const nameInput = this.querySelector('input[name="name"]');
        validateName(nameInput);
        if (!nameInput.checkValidity()) {
            e.preventDefault(); // Ngăn gửi form nếu có lỗi
        }
    });
</script>
@endsection
