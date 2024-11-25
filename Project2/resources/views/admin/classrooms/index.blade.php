@extends('layouts.dashboard')

@section('content')
<div class="classes-container">
    <div class="header">
        <h1>Class Management</h1>
        <a href="{{ route('classrooms.create') }}" class="btn-add">Add New Class</a>
    </div>

    <div class="classes-grid">
        @foreach($classrooms as $class)
            <div class="class-card">
                <div class="class-info">
                    <h3>{{ $class->name }}</h3>
                    <p>Teacher: {{ $class->user ? $class->user->name : 'N/A' }}</p>
                    <p>Status: {{ $class->status == 1 ? 'Active' : 'Inactive' }}</p>
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