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
            <input type="text" name="name" value="{{ old('name', $child->name) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate', $child->birthDate) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender', $child->gender) == 1 ? 'selected' : '' }}>Male</option>
                <option value="2" {{ old('gender', $child->gender) == 2 ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh:</label>
            @if($child->img)
                <div style="margin: 10px 0;">
                    <img src="{{ asset('storage/' . $child->img) }}" alt="Current Image" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
            <small style="color: #666;">Leave empty if not changing the image</small>
        </div>

        <button type="submit">Cập nhật thông tin trẻ</button>
    </form>
</div>
@endsection

<style>
</style>

<script>
</script>