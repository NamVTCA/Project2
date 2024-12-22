@extends('layouts.dashboard')

@section('title', 'Thêm Học Sinh vào Lớp')
<link rel="stylesheet" href="{{ asset('css/ChildClass.css') }}">
@section('content')
    <div class="container mt-4">
        <div class="back-to-dashboard">
            <button id="back-button" class="btn btn-secondary">← Quay về</button>
        </div>
        <h2 class="text-center">Thêm học sinh vào lớp</h2>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Thêm phần hiển thị lỗi --}}
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('childclass.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="child_id">Học sinh</label>
                <select name="child_id" id="child_id" class="form-control" required>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="classroom_id">Lớp học</label>
                <select name="classroom_id" id="classroom_id" class="form-control" required>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="button-group">
                <button type="submit" class="btn-custom">Thêm vào lớp</button>
                <a href="{{ route('childclass.index') }}" class="btn-custom">Xem danh sách</a>
            </div>
        </form>
    </div>
    <script>
                // Nút quay về
                document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
    </script>
@endsection