<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá theo ngày</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/EvaluateIndex.css"> <!-- Kết nối file CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@extends('layouts.dashboard') 
@section('content')
<link rel="stylesheet" href="{{ asset('css/EvaluateIndex.css') }}">
<div class="back-to-dashboard">
    <button id="back-button" class="btn btn-secondary">← Quay về</button>
</div>
<main class="schedule-section py-5">
    <div class="evaluate-page">
        <h2 class="text-pink">Đánh giá theo ngày</h2>
        <form action="{{ route('evaluate') }}" method="post" class="row">
            @csrf
           <div class="col-md-6 mb-3">
    <label for="child_id" class="form-label">Học sinh</label>
    <select name="child_id" id="child_id" class="form-select" required>
        <option value="" disabled selected>-- Chọn học sinh --</option>
        @foreach($children as $child)
            <option value="{{ $child->id }}" data-img="{{ $child->img ? asset('storage/' . $child->img) : '' }}">
                {{ $child->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-6 mb-3 text-center">
    <img id="child_image" src="" alt="Child Image" class="img-fluid" style="max-width: 100px; display: none;">
    <div id="default_avatar" class="default-avatar" style="display: none;">
        <!-- Placeholder cho avatar nếu không có ảnh -->
    </div>
</div>

            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Ngày học</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="comment" class="form-label">Nhận xét</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" maxlength="255"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <label for="point" class="form-label">Đánh giá</label>
                <select name="point" id="point" class="form-select">
                    <option value="" disabled selected>Chọn đánh giá</option>
                    <option value="10">Xuất sắc</option>
                    <option value="8">Giỏi</option>
                    <option value="6">Khá</option>
                    <option value="4">Trung bình</option>
                    <option value="2">Yếu</option>
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-pink">Gửi đánh giá</button>
            </div>
                @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
     @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
        {{-- </form>
        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</main> trùng thông báo --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const childSelect = document.getElementById('child_id');
        const childImage = document.getElementById('child_image');
        const defaultAvatar = document.getElementById('default_avatar');

        childSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const imgSrc = selectedOption.getAttribute('data-img');
            const nameInitial = selectedOption.textContent.trim().charAt(0).toUpperCase();

            if (imgSrc) {
                childImage.src = imgSrc;
                childImage.style.display = 'block';
                defaultAvatar.style.display = 'none';
            } else {
                childImage.style.display = 'none';
                defaultAvatar.textContent = nameInitial;
                defaultAvatar.style.display = 'flex';
            }
        });
    });

            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>

@endsection
