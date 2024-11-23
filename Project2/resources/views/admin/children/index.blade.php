@extends('layouts.dashboard')

@section('content')
<div class="children-container">
    <div class="header">
        <h1>Quản lý trẻ em</h1>
        <a href="{{ route('children.create') }}" class="btn-add">Thêm trẻ mới</a>
    </div>

    <div class="children-grid">
        @foreach($childrenData as $child)
        <div class="child-card">
            <div class="child-image">
                @if($child['img'])
                <img src="{{ asset('storage/' . $child['img']) }}" alt="Ảnh đại diện">
                @else
                <div class="default-avatar">
                    {{ strtoupper(substr($child['name'], 0, 1)) }}
                </div>
                @endif
            </div>
            <div class="child-info">
                <h3>{{ $child['name'] }}</h3>
                <p class="parent">Phụ huynh: {{ $child['parent_name'] }}</p>
                <p class="classroom">Lớp: {{ $child['classroom_name'] }}</p>
                <p class="birthdate">Ngày sinh: {{ $child['birthdate'] }}</p>
                <p class="gender">Giới tính: {{ $child['gender'] }}</p>
            </div>
            <div class="child-actions">
                <a href="{{ route('children.show', $child['id']) }}" class="btn-view">Xem</a>
                <a href="{{ route('children.edit', $child['id']) }}" class="btn-edit">Sửa</a>
            </div>
        </div>
        @endforeach
    </div>    
</div>

<style>
</style>
@endsection