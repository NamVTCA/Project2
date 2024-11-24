@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Chỉnh sửa thông tin trẻ</h2>

    @if($errors->any())
    <div style="color: red; margin: 10px 0;">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('children.update', $child->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Họ tên:</label>
            <input type="text" name="name" value="{{ old('name', $child->name) }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Phụ huynh:</label>
            <select name="user_id" required>
                <option value="">Chọn phụ huynh</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ $child->user_id == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate', $child->birthDate->format('Y-m-d')) }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="">Chọn giới tính</option>
                <option value="1" {{ $child->gender == 1 ? 'selected' : '' }}>Nam</option>
                <option value="2" {{ $child->gender == 2 ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh đại diện:</label>
            @if($child->img)
            <div style="margin: 10px 0;">
                <img src="{{ asset('storage/' . $child->img) }}" alt="Ảnh đại diện" style="max-width: 200px;">
            </div>
            @endif
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
            <small style="color: #666;">Để trống nếu không muốn thay đổi ảnh</small>
        </div>

        <button type="submit">Cập nhật</button>
    </form>
</div>

<style>
</style>
@endsection