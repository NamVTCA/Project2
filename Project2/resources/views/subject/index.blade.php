@extends('layouts.dashboard')

@section('content')
<div class="subjects-page">
    <link rel="stylesheet" href="{{ asset('css/Subjects.css') }}">
    <h1>Danh sách môn học</h1>

    <!-- Hiển thị thông báo -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Form thêm mới -->
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tên môn học" required>
        <button type="submit">Thêm</button>
    </form>

    <h2>Danh sách:</h2>
    <ul>
        @foreach ($subjects as $subject)
            <li>
                {{ $subject->name }}
                <!-- Nút chỉnh sửa -->
                <form action="{{ route('subjects.update', $subject->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $subject->name }}" required>
                    <button type="submit">Cập nhật</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
