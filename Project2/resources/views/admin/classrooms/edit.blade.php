@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ClassroomsCreation.css') }}">
<div class="classroom-create-page">
    <div class="back-to-dashboard">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
    </div>
    <h2>Chỉnh sửa lớp học</h2>
    @if($errors->any())
        <div class="error-list">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classrooms.update', ['classroom' => $classroom->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên lớp học:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $classroom->name) }}" required>
        </div>

        <div class="form-group">
            <label for="user_id">Giáo viên:</label>
            <select id="user_id" name="user_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('user_id', $classroom->user_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" required>
                <option value="1" {{ old('status', $classroom->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $classroom->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div id="facility-details">
            <h5>Cơ sở vật chất</h5>
            @foreach($facilities as $index => $facility)
                <div class="facility-detail" id="facility-{{ $facility->id }}">
                    <div class="form-group">
                        <label for="facility_details[{{ $index }}][total_id]">Cơ sở vật chất chung</label>
                        <select name="facility_details[{{ $index }}][total_id]" class="form-control total-select" data-index="{{ $index }}">
                            <option value="">Chọn cơ sở vật chất</option>
                            @foreach($totalFacilities as $totalFacility)
                                <option value="{{ $totalFacility->id }}" 
                                    {{ old('facility_details.' . $index . '.total_id', $facility->total_id) == $totalFacility->id ? 'selected' : '' }}>
                                    {{ $totalFacility->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="facility_details[{{ $index }}][dentail_id]">Chi tiết cơ sở vật chất</label>
                        <select name="facility_details[{{ $index }}][dentail_id]" class="form-control dentail-select" id="dentail-select-{{ $index }}" required>
                            <option value="">Chọn chi tiết cơ sở vật chất</option>
                            @foreach($totalFacility->dentail as $dentail)
                                <option value="{{ $dentail->id }}" 
                                    {{ old('facility_details.' . $index . '.dentail_id', $facility->dentail_id) == $dentail->id ? 'selected' : '' }}>
                                    {{ $dentail->name }} (Còn lại: {{ $dentail->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="facility_details[{{ $index }}][quantity]">Số lượng</label>
                        <input type="number" name="facility_details[{{ $index }}][quantity]" value="{{ old('facility_details.' . $index . '.quantity', $facility->quantity) }}" class="form-control">
                    </div>
                    <button type="button" class="btn btn-danger remove-facility" data-id="{{ $facility->id }}">Xóa</button>
                </div>
            @endforeach
        </div>        

        <input type="hidden" name="deleted_facilities" id="deleted-facilities">

        <button type="button" id="add-facility" class="btn btn-secondary">Thêm cơ sở vật chất</button>
        <button type="submit" class="btn btn-primary">Cập nhật lớp</button>
    </form>    
</div>

<script>
    let facilities = @json($totalFacilities);

    document.getElementById('add-facility').addEventListener('click', function () {
        const facilityDetails = document.getElementById('facility-details');
        const index = facilityDetails.getElementsByClassName('facility-detail').length;

        let options = facilities.map(facility => `<option value="${facility.id}">${facility.name}</option>`).join('');

        const newDetail = `
            <div class="facility-detail">
                <div class="form-group">
                    <label for="facility_details[${index}][total_id]">Cơ sở vật chất chung</label>
                    <select name="facility_details[${index}][total_id]" class="form-control total-select" data-index="${index}" required>
                        <option value="">Chọn cơ sở vật chất</option>
                        ${options}
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
            const facilityId = e.target.getAttribute('data-id');
            if (facilityId) {
                const deletedFacilities = document.getElementById('deleted-facilities');
                let deletedIds = deletedFacilities.value ? deletedFacilities.value.split(',') : [];
                deletedIds.push(facilityId);
                deletedFacilities.value = deletedIds.join(',');
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