@extends('layouts.dashboard')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-basic-info">
            <h1>{{ $classroom->name }}</h1>
            <p>Teacher: {{ $classroom->user ? $classroom->user->name : 'N/A' }}</p>
            <p>Status: {{ $classroom->status == 1 ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>
</div>
@endsection