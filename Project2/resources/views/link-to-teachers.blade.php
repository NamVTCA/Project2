@extends('layouts.dashboard')

@section('title', 'Đội Ngũ Giảng Dạy')
<link rel="stylesheet" href="{{ asset('css/Teachers.css') }}">
@section('content')
<div class="container teachers-page">
    <h1 class="page-title">Đội Ngũ Giảng Dạy</h1>
    <div class="row">
        @foreach($teachers as $teacher)
            <div class="col-md-4 teacher-card">
                <div class="card">
                    <img src="{{ asset('storage/avatars/' . $teacher->avatar) }}" class="card-img-top" alt="Ảnh của {{ $teacher->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $teacher->name }}</h5>
                        <p class="card-text"><strong>Chuyên môn:</strong> {{ $teacher->specialty }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $teacher->email }}</p>
                        <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
