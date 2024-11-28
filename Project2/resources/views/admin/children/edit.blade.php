@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Chỉnh sửa thông tin học sinh</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('children.update', $child->id) }}" method="POST" enctype="multipart/form-data" id="childForm">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" required pattern="^[\p{L}\s]+$" title="Tên chỉ được chứa chữ cái và khoảng trắng" oninput="validateName(this)">
            <span class="error-message" style="color: red; display: none;">Vui lòng nhập tên hợp lệ (chỉ chứa chữ cái và khoảng trắng).</span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" max="{{ date('Y-m-d') }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender', $child->gender) == 1 ? 'selected' : '' }}>Nam</option>
                <option value="2" {{ old('gender', $child->gender) == 2 ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
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

        <div style="margin-bottom: 15px;">
            <label>Trạng thái:</label>
            <select name="status" required>
                <option value="1" {{ old('status', $child->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $child->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
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

        <button type="submit">Cập nhật thông tin học sinh</button>
    </form>
</div>
<script>
    function validateName(input) {
        const pattern = /^[\p{L}\s]+$/u; // Updated pattern to support Unicode letters properly, including accented characters
        const errorMessage = input.nextElementSibling;
        if (!pattern.test(input.value)) {
            errorMessage.style.display = 'block'; // Show error message if input is invalid
            input.setCustomValidity('Tên chỉ được chứa chữ cái và khoảng trắng');
        } else {
            errorMessage.style.display = 'none'; // Hide error message if input is valid
            input.setCustomValidity(''); // Reset custom validity
        }
    }
</script>
@endsection