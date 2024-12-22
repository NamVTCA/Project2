@extends('layouts.dashboard')

@section('title', 'CameraCreate')

@section('content')
<link rel="stylesheet" href="{{ asset('css/CameraCreate.css') }}">
<div class="back-to-dashboard">
    <button id="back-button" class="btn btn-secondary">← Quay về</button>
</div>
<div class="container-camera-create">
    <h1>Thêm camera</h1>
    <form action="{{ route('cameras.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên camera:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="stream_url">Stream URL:</label>
            <input type="url" name="stream_url" id="stream_url" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm camera</button>
    </form>
</div>

<script>
            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection
