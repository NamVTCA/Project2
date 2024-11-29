@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ClassroomsCreation.css') }}">
<div class="classroom-create-page">
    <h2>Tạo lớp học mới</h2>
    @if($errors->any())
        <div class="error-list">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classrooms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên lớp học:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="user_id">Giáo viên:</label>
            <select id="user_id" name="user_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('user_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" required>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div id="facility-details">
            <h5>Cơ sở vật chất</h5>
            <div class="facility-detail">
                <div class="form-group">
                    <label for="facility_details[0][name]">Tên</label>
                    <input type="text" name="facility_details[0][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="facility_details[0][status]">Trạng thái</label>
                    <input type="text" name="facility_details[0][status]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="facility_details[0][quantity]">Chất lượng</label>
                    <input type="number" name="facility_details[0][quantity]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" id="add-facility" class="btn btn-secondary">Thêm cơ sở vật chất</button>
        <button type="submit" class="btn btn-primary">Tạo lớp</button>
    </form>
</div>

<script>
    document.getElementById('add-facility').addEventListener('click', function () {
        const facilityDetails = document.getElementById('facility-details');
        const index = facilityDetails.getElementsByClassName('facility-detail').length;
        const newDetail = `
            <div class="facility-detail">
                <div class="form-group">
                    <label for="facility_details[${index}][name]">Tên</label>
                    <input type="text" name="facility_details[${index}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="facility_details[${index}][status]">Trạng thái</label>
                    <input type="text" name="facility_details[${index}][status]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="facility_details[${index}][quantity]">Chất lượng</label>
                    <input type="number" name="facility_details[${index}][quantity]" class="form-control" required>
                </div>
            </div>
        `;
        facilityDetails.insertAdjacentHTML('beforeend', newDetail);
    });
</script>
@endsection
