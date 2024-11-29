
@extends('layouts.dashboard')

@section('title', 'Lịch Học Nhà Trẻ')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/NurserySchedule.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<main class="schedule-section py-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color:#d6336c;">Lịch học Nhà trẻ</h2>
        <form class="row mb-4">
            <div class="col-md-6">
                <label for="classroom_id" class="form-label">Lớp học</label>
                <select name="classroom_id" id="classroom_id" class="form-select" required>
                    <option value="">-- Chọn lớp học --</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Ngày học</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
        </form>
        <div class="schedule-details mt-4">
            <h3 class="text-center mb-3 text-secondary">Chi Tiết Lịch Học</h3>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Tiết Học</th>
                        <th>Môn Học</th>
                    </tr>
                    </thead>
                    <tbody id="schedule-details-body">
                    <tr>
                        <td colspan="3" class="text-center text-muted">Chọn lớp và ngày học để hiển thị lịch.</td>
                    </tr>
                    </tbody>
                </table>

    
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('classroom_id').addEventListener('change', loadSchedule);
    document.getElementById('date').addEventListener('change', loadSchedule);

    function loadSchedule() {
        const classroomId = document.getElementById('classroom_id').value;
        const date = document.getElementById('date').value;

        if (classroomId && date) {
            fetch(`/api/schedule/details?classroom_id=${classroomId}&date=${date}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('schedule-details-body');
                    tableBody.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            tableBody.innerHTML += `
                                <tr>
                                    <td>${item.name}</td>
                                    <td>${item.subject_name}</td>
                                </tr>`;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Không có dữ liệu.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                });
        }

    }
</script>
@endsection

