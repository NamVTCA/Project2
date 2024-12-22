@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/FacilitiesCreation.css') }}">
<div class="facility-edit-page">
    <h2>Chỉnh sửa cơ sở vật chất</h2>
    <div class="back-to-dashboard">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
    </div>
    @if($errors->any())
        <div class="error-list">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('facility_management.update', ['total' => $total->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên cơ sở vật chất:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $total->name) }}" required>
        </div>

        <div id="dentail-details">
            <h5>Chi tiết cơ sở vật chất</h5>
            @foreach($total->dentail as $index => $dentail)
                <div class="dentail-detail" id="dentail-{{ $dentail->id }}">
                    <div class="form-group">
                        <label for="dentail[{{ $index }}][name]">Tên chi tiết</label>
                        <input type="text" name="dentail[{{ $index }}][name]" class="form-control" value="{{ old('dentail.' . $index . '.name', $dentail->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dentail[{{ $index }}][status]">Trạng thái</label>
                        <input type="text" name="dentail[{{ $index }}][status]" class="form-control" value="{{ old('dentail.' . $index . '.status', $dentail->status) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dentail[{{ $index }}][quantity]">Số lượng</label>
                        <input type="number" name="dentail[{{ $index }}][quantity]" class="form-control" value="{{ old('dentail.' . $index . '.quantity', $dentail->quantity) }}" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-dentail" data-id="{{ $dentail->id }}">Xóa</button>
                </div>
            @endforeach
        </div>

        <input type="hidden" name="deleted_dentails" id="deleted-dentails">

        <button type="button" id="add-dentail" class="btn btn-secondary">Thêm chi tiết</button>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<script>
    let dentailIndex = {{ count($total->dentail) }};

    document.getElementById('add-dentail').addEventListener('click', function () {
        const dentailDetails = document.getElementById('dentail-details');

        const newDetail = `
            <div class="dentail-detail">
                <div class="form-group">
                    <label for="dentail[${dentailIndex}][name]">Tên Chi Tiết</label>
                    <input type="text" name="dentail[${dentailIndex}][name]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dentail[${dentailIndex}][status]">Trạng Thái</label>
                    <input type="text" name="dentail[${dentailIndex}][status]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dentail[${dentailIndex}][quantity]">Số Lượng</label>
                    <input type="number" name="dentail[${dentailIndex}][quantity]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger remove-dentail">Xóa</button>
            </div>
        `;
        dentailDetails.insertAdjacentHTML('beforeend', newDetail);
        dentailIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-dentail')) {
            const dentailId = e.target.getAttribute('data-id');
            if (dentailId) {
                const deletedDentails = document.getElementById('deleted-dentails');
                let deletedIds = deletedDentails.value ? deletedDentails.value.split(',') : [];
                deletedIds.push(dentailId);
                deletedDentails.value = deletedIds.join(',');
            }
            e.target.parentElement.remove();
        }
    });

            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection