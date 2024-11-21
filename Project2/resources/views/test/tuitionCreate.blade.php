@extends('layouts.app')

@section('content')
<div class="container">
    <link rel="stylesheet" href="{{ asset('css/TuitionCreate.css') }}">
    <h1>Tạo Học phí</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tuition.store') }}" method="POST">
        @csrf

        <!-- Chọn lớp -->
        <div class="form-group">
            <label for="classroom_id">Lớp học</label>
            <select name="classroom_id" id="classroom_id" class="form-control" required>
                <option value="">-- Chọn lớp học --</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="semester">Học kỳ</label>
            <input type="text" name="semester" id="semester" class="form-control" required>
        </div>

        <div id="tuition-details">
            <h5>Chi tiết học phí</h5>
            <div class="tuition-detail">
                <div class="form-group">
                    <label for="tuition_details[0][name]">Tên</label>
                    <input type="text" name="tuition_details[0][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tuition_details[0][price]">Giá</label>
                    <input type="number" name="tuition_details[0][price]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" id="add-detail" class="btn btn-secondary">Thêm chi tiết</button>

        <button type="submit" class="btn btn-primary">Tạo Học phí</button>
    </form>
</div>

<script>
    document.getElementById('add-detail').addEventListener('click', function () {
        const tuitionDetails = document.getElementById('tuition-details');
        const index = tuitionDetails.getElementsByClassName('tuition-detail').length;
        const newDetail = `
            <div class="tuition-detail">
                <div class="form-group">
                    <label for="tuition_details[${index}][name]">Name</label>
                    <input type="text" name="tuition_details[${index}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tuition_details[${index}][price]">Price</label>
                    <input type="number" name="tuition_details[${index}][price]" class="form-control" required>
                </div>
            </div>
        `;
        tuitionDetails.insertAdjacentHTML('beforeend', newDetail);
    });
</script>
@endsection