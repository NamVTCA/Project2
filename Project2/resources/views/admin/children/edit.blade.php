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
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            <span class="invalid-feedback" id="name-error"></span>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
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
    document.addEventListener('DOMContentLoaded', function() 
    {
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
    })
</script>
@endsection
