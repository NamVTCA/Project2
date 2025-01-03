@extends('layouts.dashboard')

@section('title', 'Danh Sách Học Sinh trong Lớp')
<link rel="stylesheet" href="{{ asset('css/ChildClass.css') }}">

@section('content')
<div class="back-button">
    <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Quay về
    </a>
</div>
<div class="container mt-4">
    <h2 class="text-center">Danh sách học sinh trong lớp</h2>

    <!-- Bộ lọc -->
    <form action="{{ route('childclass.index') }}" method="GET" class="form-inline mb-4">
        <div class="form-group mr-3">
            <label for="classroom_id" class="mr-2">Lọc theo lớp:</label>
            <select name="classroom_id" id="classroom_id" class="form-control">
                <option value="">Tất cả lớp</option>
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" 
                        {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>

    <!-- Bảng danh sách học sinh -->
    <div class="table-responsive mt-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Học sinh</th>
                    <th>Lớp học</th>
                    <th>Ngày thêm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($childclasses as $childclass)
                    <tr>
                        <td>{{ $childclass->child->name }}</td>
                        <td>{{ $childclass->classroom->name }}</td>
                        <td>{{ $childclass->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('childclass.edit', ['child_id' => $childclass->child_id, 'classroom_id' => $childclass->classroom_id]) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Không có học sinh nào trong lớp này.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection
