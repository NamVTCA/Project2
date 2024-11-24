@extends('layouts.dashboard')

@section('content')
<div class="children-container">
    <div class="header">
        <h1>Quản lý học sinh</h1>
        <a href="{{ route('children.create') }}" class="btn-add">Thêm học sinh mới</a>
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

<style>
</style>

<script>
</script>