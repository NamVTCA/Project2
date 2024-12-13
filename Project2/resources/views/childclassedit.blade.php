@extends('layouts.dashboard')

@section('title', 'Chỉnh Sửa Học Sinh trong Lớp')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ChildClass.css') }}">

<div class="container mt-4">
    <h2 class="text-center">Chỉnh Sửa Học Sinh trong Lớp</h2>

    {{-- Hiển thị thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    {{-- Hiển thị thông báo lỗi --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <form action="{{ route('childclass.update', ['child_id' => $childclass->child_id, 'classroom_id' => $childclass->classroom_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="child_id">Học Sinh</label>
            <select name="child_id" id="child_id" class="form-control" required>
                @foreach($children as $child)
                    <option value="{{ $child->id }}" {{ $childclass->child_id == $child->id ? 'selected' : '' }}>
                        {{ $child->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="classroom_id">Lớp Học</label>
            <select name="classroom_id" id="classroom_id" class="form-control" required>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ $childclass->classroom_id == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Cập Nhật</button>
    </form>
</div>
@endsection