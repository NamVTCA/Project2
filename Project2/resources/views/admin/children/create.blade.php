@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Thêm học sinh mới</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data" id="childForm">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Tên:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ngày sinh:</label>
            <input type="date" name="birthDate" value="{{ old('birthDate') }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Ảnh:</label>
            <input type="file" name="img" accept="image/jpeg,image/png,image/jpg">
        </div>

        <button type="submit">Tạo học sinh</button>
    </form>
</div>
@endsection

<style>
</style>

<script>
</script>