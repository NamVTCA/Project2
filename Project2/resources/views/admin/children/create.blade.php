@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Thêm trẻ mới</h2>

    @if($errors->any())
    <div style="color: red; margin: 10px 0;">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Họ tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Phụ huynh:</label>
            <select name="user_id" required>
                <option value="">Chọn phụ huynh</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="">Chọn giới tính</option>
                <option value="1">Nam</option>
                <option value="2">Nữ</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh đại diện:</label>
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
        </div>

        <button type="submit">Thêm trẻ</button>
    </form>
</div>

<style>
</style>
@endsection