@extends('layouts.dashboard')

@section('title', 'Danh sách Camera')

@section('content')
<link rel="stylesheet" href="{{ asset('css/CamIndex.css') }}">

<div class="container camera-page">
    <!-- Nút quay về -->
    <div class="back-to-dashboard">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
    </div>

    <!-- Tiêu đề -->
    <h1>Danh sách camera</h1>

    <!-- Danh sách camera -->
    <div class="row">
        @foreach($cameras as $camera)
        <div class="col-md-4 camera-card">
            <!-- Tên camera -->
            <h3 class="camera-name">{{ $camera->name }}</h3>
        
            <!-- Hiển thị video -->
            <div class="camera-stream">
                <iframe src="{{ $camera->stream_url }}" frameborder="0" allowfullscreen></iframe>
            </div>
        
            <!-- Nút hành động -->
            <div class="camera-actions">
                <form action="{{ route('camera.delete', $camera->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa camera này không?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                    <a href="{{ $camera->stream_url }}" target="_blank" class="btn btn-primary">Xem toàn bộ</a>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    // Nút quay về
    document.getElementById('back-button').addEventListener('click', function () {
        window.history.back();
    });
</script>
@endsection
