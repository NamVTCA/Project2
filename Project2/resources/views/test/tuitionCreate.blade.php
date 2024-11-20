@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Tuition</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tuition.store') }}" method="POST">
        @csrf

        <!-- Chọn lớp -->
        <div class="form-group">
            <label for="classroom_id">Classroom</label>
            <select name="classroom_id" id="classroom_id" class="form-control" required>
                <option value="">-- Select Classroom --</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>
            <input type="text" name="semester" id="semester" class="form-control" required>
        </div>

        <div id="tuition-details">
            <h5>Tuition Details</h5>
            <div class="tuition-detail">
                <div class="form-group">
                    <label for="tuition_details[0][name]">Name</label>
                    <input type="text" name="tuition_details[0][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tuition_details[0][price]">Price</label>
                    <input type="number" name="tuition_details[0][price]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" id="add-detail" class="btn btn-secondary">Add Detail</button>

        <button type="submit" class="btn btn-primary">Create Tuition</button>
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