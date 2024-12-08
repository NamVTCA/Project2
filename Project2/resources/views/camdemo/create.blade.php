@extends('layouts.dashboard')

@section('title', 'CameraCreate')

@section('content')
<link rel="stylesheet" href="{{ asset('css/CameraCreate.css') }}">
<div class="container-camera-create">
    <h1>Add New Camera</h1>
    <form action="{{ route('cameras.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Camera Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="stream_url">Stream URL:</label>
            <input type="url" name="stream_url" id="stream_url" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Add Camera</button>
    </form>
</div>
@endsection
