@extends('layouts.dashboard')

@section('content')
<div>
    <h2>Chỉnh sửa thông tin lớp học</h2>

    @if($errors->any())
        <div style="color: red; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" id="classForm">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Tên lớp học:</label>
            <input type="text" name="name" value="{{ old('name', $classroom->name) }}" required>
            <span class="error-message"></span>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Giáo viên:</label>
            <select name="user_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('user_id', $classroom->user_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Trạng thái:</label>
            <select name="status" required>
                <option value="1" {{ old('status', $classroom->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $classroom->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <button type="submit">Cập nhật thông tin lớp họ<colgroup></colgroup></button>
    </form>
</div>
@endsection