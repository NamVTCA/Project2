@extends('layouts.dashboard')

@section('content')
<div>
    <link rel="stylesheet" href="{{ asset('css/ChildrenCreation.css') }}">
    <a href="{{ route('admin') }}" class="btn btn-secondary mb-3">← Quay về</a>
    <h2>Tạo học sinh mới</h2>

    <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data" id="childForm">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" required pattern="^[\p{L}\s]+$" title="Tên chỉ được chứa chữ cái và khoảng trắng" oninput="validateName(this)">
            <span class="error-message" style="color: red; display: none;">Vui lòng nhập tên hợp lệ (chỉ chứa chữ cái và khoảng trắng).</span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" max="{{ date('Y-m-d') }}" required>
            @error('birthDate')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Nam</option>
                <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Phụ huynh:</label>
            <select name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $child->user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
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
            <label>Ảnh đại diện:</label>
            @if(isset($user) && $user->img)
                <div style="margin: 10px 0;">
                    <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
        </div>        

        <button type="submit">Tạo học sinh</button>
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
</script>
@endsection
