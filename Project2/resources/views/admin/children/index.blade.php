@extends('layouts.dashboard')
<link rel="stylesheet" href="{{ asset('css/ChildrenManagement.css') }}">
@section('content')
<div class="children-container">
    <div class="header">
        <h1>Quản lý học sinh</h1>
        <div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Thêm học sinh
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('children.create') }}">Thêm một học sinh</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importChildModal">Thêm nhiều học sinh</a></li>
                </ul>
            </div>
            <a href="{{ route('childclass.create') }}" class="btn-add">Thêm học sinh vào lớp</a>
            <a href="{{ route('children.export') }}" class="btn-add">Xuất Excel</a>
        </div>
    </div>
</div>
<a href="{{ route('admin') }}" class="btn btn-secondary mb-3">← Quay về</a>
    <div class="children-grid">
        @foreach($children as $child)
            <div class="child-card">
                <div class="child-image">
                    @if($child->img)
                        <img src="{{ asset('storage/' . $child->img) }}" alt="Child Image">
                    @else
                        <div class="default-avatar">
                            {{ strtoupper(substr($child->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="child-info">
                    <h3>{{ $child->name }}</h3>
                    <p>Ngày sinh: {{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</p>
                    <p>Giới tính: {{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                    <p>Phụ huynh: {{ $child->user ? $child->user->name : 'N/A' }}</p>
                </div>
                <div class="child-actions">
                    <a href="{{ route('children.edit', $child->id) }}" class="btn-edit">Sửa</a>
                </div>
            </div>
        @endforeach
    </div>
    {{-- Thêm phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $children->links('vendor.pagination.default') }}
    </div>
    <!-- Import Child Modal -->
    <div class="modal fade" id="importChildModal" tabindex="-1" aria-labelledby="importChildModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importChildModalLabel">Import Học Sinh từ Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('children.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Chọn file Excel</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                    @if(session('import_errors'))
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach(session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection