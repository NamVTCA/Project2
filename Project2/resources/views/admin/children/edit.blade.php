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
            <input type="text" name="name" value="{{ old('name') }}" required pattern="^[\p{L}\s]+$" title="Tên chỉ được chứa chữ cái và khoảng trắng" oninput="validateName(this)">
            <span class="error-message" style="color: red; display: none;">Vui lòng nhập tên hợp lệ (chỉ chứa chữ cái và khoảng trắng).</span>
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
    function validateName(input) {
        const pattern = /^[\p{L}\s]+$/u; 
        const errorMessage = input.nextElementSibling;
        if (!pattern.test(input.value)) {
            errorMessage.style.display = 'block'; 
            input.setCustomValidity('Tên chỉ được chứa chữ cái và khoảng trắng');
        } else {
            errorMessage.style.display = 'none'; 
            input.setCustomValidity(''); 
        }
    }

    document.getElementById('childForm').addEventListener('submit', function (e) {
        const nameInput = this.querySelector('input[name="name"]');
        validateName(nameInput);
        if (!nameInput.checkValidity()) {
            e.preventDefault();
        }
    });
</script>
@endsection
