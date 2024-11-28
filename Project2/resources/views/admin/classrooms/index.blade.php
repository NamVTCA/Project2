@extends('layouts.dashboard')

@section('content')
<div class="classes-container">
    <div class="header">
        <h1>Quản lý lớp học</h1>
        <a href="{{ route('classrooms.create') }}" class="btn-add">Thêm lớp học mới</a>
        
    </div>

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
                                <li>{{ $facility->name }} - Trạng thái: {{ $facility->status }} - Số lượng: {{ $facility->quantity }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="class-actions">
                    <a href="{{ route('classrooms.show', $class->id) }}" class="btn-view">View</a>
                    <a href="{{ route('classrooms.edit', $class->id) }}" class="btn-edit">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
