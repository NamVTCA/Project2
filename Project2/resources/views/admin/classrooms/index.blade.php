@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ClassroomsIndex.css') }}">
<div class="classes-container">
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <div class="header">
        <h1>Quản lý lớp học</h1>
        <a href="{{ route('classrooms.create') }}" class="btn-add">Thêm lớp học mới</a>
        <a href="{{ route('facility_management.index') }}" class="btn btn-primary">Quản lý cơ sở vật chất</a>
    </div>
    <div class="class-card highlight">
        <div class="classes-grid">
            @foreach($classrooms as $class)
                <div class="class-card">
                    <div class="class-info">
                        <h3>{{ $class->name }}</h3>
                        <p>Giáo viên: {{ $class->user ? $class->user->name : 'N/A' }}</p>
                        <p>Trạng thái: {{ $class->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</p>
                        <h5>Cơ sở vật chất:</h5>
                        @if($class->facilities->isEmpty())
                            <p>Không có cơ sở vật chất nào</p>
                        @else
                            <ul>
                                @foreach($class->facilities as $facility)
                                    <li>
                                        Cơ sở vật chất: {{ $facility->name ?? 'N/A' }} -  
                                        Số lượng: {{ $facility->quantity }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="class-actions">
                        <a href="{{ route('classrooms.edit', $class->id) }}" class="btn-edit">Chỉnh sửa</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
// Nút quay về
document.getElementById('back-button').addEventListener('click', function () {
    window.history.back();
});
</script>
@endsection