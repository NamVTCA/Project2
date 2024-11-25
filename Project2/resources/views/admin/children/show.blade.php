@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image">
            @if($user->img)
                <img src="{{ asset('storage/' . $user->img) }}" alt="Profile Image" style="max-width: 200px;">
            @else
                <div class="default-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>        
        <div class="profile-basic-info">
            <h1>{{ $child->name }}</h1>
            <p>Birth Date: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
            <p>Gender: {{ $child->gender == 1 ? 'Male' : 'Female' }}</p>
            <p>Parent: {{ $child->user ? $child->user->name : 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection