@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            @if($child->user && $child->user->img)
                @php
                    $imagePath = 'storage/' . $child->user->img;
                @endphp
                <img src="{{ asset($imagePath) }}" alt="Profile Image" style="max-width: 200px;">
                <p>Đường dẫn ảnh: {{ asset($imagePath) }}</p> <!-- Hiển thị đường dẫn để kiểm tra -->
            @else
                <div class="default-avatar">
                    {{ strtoupper(substr($child->user ? $child->user->name : 'N/A', 0, 1)) }}
                </div>
            @endif
        </div>                 
        <div class="profile-basic-info">
            <h1>{{ $child->name }}</h1>
            <p>Ngày sinh: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
            <p>Giới tính: {{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</p>
            <p>Phụ huynh: {{ $child->user ? $child->user->name : 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection