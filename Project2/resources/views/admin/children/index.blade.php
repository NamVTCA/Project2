@extends('layouts.dashboard')
<link rel="stylesheet" href="{{ asset('css/ChildrenManagement.css') }}">
@section('content')
<div class="children-container">
    <div class="header">
        <h1>Quản lý học sinh</h1>
        <div>
            <a href="{{ route('children.create') }}" class="btn-add">Thêm học sinh mới</a>
            <a href="{{ route('childclass.create') }}" class="btn-add">Thêm học sinh vào lớp</a>
        </div>
    </div>
</div>


    <div class="children-grid">
        @foreach($children as $child)
            <div class="child-card">
                <div class="child-image">
                    @if($child->img)
                        <img src="{{ asset('storage/' . $child->img) }}" alt="Child Image">
                    @else
                        <div class="default-avatar">
                            {{ strtoupper(substr($child->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="child-info">
                    <h3>{{ $child->name }}</h3>
                    <p>Ngày sinh: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
                    <p>Giới tính: {{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                    <p>Phụ huynh: {{ $child->user ? $child->user->name : 'N/A' }}</p>
                </div>
                <div class="child-actions">
                    <a href="{{ route('children.edit', $child->id) }}" class="btn-edit">Sửa</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection