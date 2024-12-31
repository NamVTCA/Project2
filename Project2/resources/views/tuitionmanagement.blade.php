@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/TuitionManagement.css') }}">
<div class="hoc-phi-container">
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <h1>Quản lý học phí</h1>

    <div class="actions">
        <a href="{{ route('tuition.create') }}" class="btn">Tạo học phí</a>
    </div>

    <form method="GET" action="{{ route('tuition.index') }}">
        <div class="form-group">
            <label for="classroom_id">Chọn Lớp</label>
            <select name="classroom_id" id="classroom_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Chọn lớp --</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="children_id">Chọn học sinh</label>
            <select name="children_id" id="children_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Chọn học sinh --</option>
                @foreach($children as $child)
                    <option value="{{ $child->id }}" {{ request('children_id') == $child->id ? 'selected' : '' }}>
                        {{ $child->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($selectedChild)
        <div class="child-info">
            <h3>Thông tin trẻ</h3>
            <p><strong>Tên phụ huynh:</strong> {{ $selectedChild->user->name }}</p>
            <p><strong>Ngày sinh:</strong> {{ $selectedChild->birthDate }}</p>
            <p><strong>Giới tính:</strong> {{ $selectedChild->gender == 1 ? 'Nam' : 'Nữ' }}</p>
        </div>

        <table class="tuition-table">
            <thead>
                <tr>
                    <th>Kỳ học</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($selectedChild->tuition as $tuition)
                    <tr>
                        <td>{{ $tuition->semester }}</td>
                        <td>{{ $tuition->status ? 'Đã đóng' : 'Chưa đóng' }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
<script>
            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection
