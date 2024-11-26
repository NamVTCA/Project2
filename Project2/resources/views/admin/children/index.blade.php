@extends('layouts.dashboard')

@section('content')
<div class="children-container">
    <div class="header">
        <link rel="stylesheet" href="{{ asset('css/ChildrenManagement.css') }}">
        <h1>Children Management</h1>
        <a href="{{ route('children.create') }}" class="btn-add">Add New Child</a>
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
                    <p>Birth Date: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
                    <p>Gender: {{ $child->gender == 1 ? 'Male' : 'Female' }}</p>
                    <p>Parent: {{ $child->user ? $child->user->name : 'N/A' }}</p>
                </div>
                <div class="child-actions">
                    <a href="{{ route('children.show', $child->id) }}" class="btn-view">View</a>
                    <a href="{{ route('children.edit', $child->id) }}" class="btn-edit">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection