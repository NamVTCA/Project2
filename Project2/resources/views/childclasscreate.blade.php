@extends('layouts.dashboard')

@section('title', 'Thêm Học Sinh vào Lớp')
<link rel="stylesheet" href="{{ asset('css/ChildClass.css') }}">
@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Thêm Học Sinh vào Lớp</h2>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('childclass.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="child_id">Học Sinh</label>
                <select name="child_id" id="child_id" class="form-control" required>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group mt-3">
                <label for="classroom_id">Lớp Học</label>
                <select name="classroom_id" id="classroom_id" class="form-control" required>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>       
            <div class="button-group">
                <button type="submit" class="btn-custom">Thêm vào lớp</button>
                <a href="{{ route('childclass.index') }}" class="btn-custom">Xem Danh Sách</a>
            </div>  
        </form>
    </div>
@endsection
