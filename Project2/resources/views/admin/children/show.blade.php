@extends('layouts.dashboard')

@section('content')
<div class="child-profile">
    <div class="profile-header">
        <div class="profile-image">
            @if($child->img)
            <img src="{{ asset('storage/' . $child->img) }}" alt="Ảnh đại diện">
            @else
            <div class="default-avatar">
                {{ strtoupper(substr($child->name, 0, 1)) }}
            </div>
            @endif
        </div>
        <div class="profile-info">
            <h1>{{ $child->name }}</h1>
            <p class="parent">Phụ huynh: {{ $parent->name }}</p>
            <p class="classroom">Lớp: {{ $child->classroom->name ?? 'Chưa được phân lớp' }}</p>
            <p class="birthdate">Ngày sinh: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
            <p class="gender">Giới tính: {{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</p>
        </div>
    </div>
</div>

<style>
</style>
@endsection
