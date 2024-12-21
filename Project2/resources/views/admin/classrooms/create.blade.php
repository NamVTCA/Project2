@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ClassroomsCreation.css') }}">
<div class="classroom-create-page">
    <div class="back-to-dashboard">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
    </div>
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
                @foreach($allTeachers as $teacher)
                    @if($teacher->classroom)
                        <option value="{{ $teacher->id }}" disabled style="color: gray;">
                            {{ $teacher->name }} (đã phân lớp)
                        </option>
                    @endif
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
            <button type="button" id="add-facility" class="btn btn-secondary">Thêm cơ sở vật chất</button>
        </div>

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
                    <label for="facility_details[${index}][total_id]">Cơ sở vật chất chung</label>
                    <select name="facility_details[${index}][total_id]" class="form-control total-select" data-index="${index}" required>
                        <option value="">Chọn cơ sở vật chất</option>
                        @foreach($totalFacilities as $total)
                            <option value="{{ $total->id }}">{{ $total->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="facility_details[${index}][dentail_id]">Chi tiết cơ sở vật chất</label>
                    <select name="facility_details[${index}][dentail_id]" class="form-control dentail-select" id="dentail-select-${index}" required>
                        <option value="">Chọn chi tiết cơ sở vật chất</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="facility_details[${index}][quantity]">Số lượng</label>
                    <input type="number" name="facility_details[${index}][quantity]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-facility">Xóa</button>
            </div>
        `;
        facilityDetails.insertAdjacentHTML('beforeend', newDetail);
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('total-select')) {
            const index = e.target.getAttribute('data-index');
            const totalId = e.target.value;

            // Fetch the related dentail_facilities
            fetch(`/api/get-dentails/${totalId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Chọn chi tiết cơ sở vật chất</option>';
                    data.forEach(dentail => {
                        options += `<option value="${dentail.id}">${dentail.name} (Còn lại: ${dentail.quantity})</option>`;
                    });
                    document.getElementById(`dentail-select-${index}`).innerHTML = options;
                });
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-facility')) {
            e.target.parentElement.remove();
        }
    });

            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection