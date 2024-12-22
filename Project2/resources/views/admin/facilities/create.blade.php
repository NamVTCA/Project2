@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/FacilitiesCreation.css') }}">
<div class="facility-create-page">
    <h2>Thêm cơ sở vật chất mới</h2>
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <form action="{{ route('facility_management.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên cơ sở vật chất:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div id="dentail-details">
            <h5>Chi tiết cơ sở vật chất</h5>
            <button type="button" id="add-dentail" class="btn btn-secondary">Thêm chi tiết</button>
        </div>

        <button type="submit" class="btn btn-primary">Tạo mới</button>
    </form>
</div>

<script>
    document.getElementById('add-dentail').addEventListener('click', function () {
        const dentailDetails = document.getElementById('dentail-details');
        const index = dentailDetails.getElementsByClassName('dentail-detail').length;
        const newDetail = `
            <div class="dentail-detail">
                <div class="form-group">
                    <label for="dentail[${index}][name]">Tên Chi Tiết</label>
                    <input type="text" name="dentail[${index}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dentail[${index}][status]">Trạng Thái</label>
                    <input type="text" name="dentail[${index}][status]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dentail[${index}][quantity]">Số Lượng</label>
                    <input type="number" name="dentail[${index}][quantity]" class="form-control" required>
                </div>
            </div>
        `;
        dentailDetails.insertAdjacentHTML('beforeend', newDetail);
    });
            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection