@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            @if($child->img)
                <img src="{{ asset('storage/' . $child->img) }}" alt="Child Image">
            @else
                <div class="default-avatar">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="profile-basic-info">
            <h1>{{ $child->name }}</h1>
            <p>Ngày sinh: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
            <p>Giới tính: {{ $child->gender == 1 ? 'Male' : 'Female' }}</p>
        </div>
    </div>
</div>
@endsection

<style>
</style>

<script>
</script>