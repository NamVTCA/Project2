@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/FacilitiesCreation.css') }}">
<div class="facility-create-page">
    <h2>Thêm Cơ Sở Vật Chất Mới</h2>

    <form action="{{ route('facility_management.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên Cơ Sở Vật Chất:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div id="dentail-details">
            <h5>Chi Tiết Cơ Sở Vật Chất</h5>
            <button type="button" id="add-dentail" class="btn btn-secondary">Thêm Chi Tiết</button>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Mới</button>
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
</script>
@endsection