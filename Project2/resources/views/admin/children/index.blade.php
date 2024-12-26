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
                    <li><a class="dropdown-item" href="{{ route('admin.children.create') }}">Thêm một học sinh</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importChildModal">Thêm nhiều học sinh</a></li>
                </ul>
            </div>
            <a href="{{ route('childclass.create') }}" class="btn-add">Thêm học sinh vào lớp</a>
            <a href="{{ route('admin.children.export') }}" class="btn-add">Xuất tệp Excel</a>
        </div>
    </div>
</div>
<div class="back-button">
    <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Quay về
    </a>
</div>
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
                    <a href="{{ route('admin.children.edit', $child->id) }}" class="btn-edit">Sửa</a>
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
                    <h5 class="modal-title" id="importChildModalLabel">Thêm học sinh từ tệp Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.children.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Chọn tệp Excel</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Nhập</button>
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


<!-- Modal Quy Định -->
<div class="modal fade" id="rulesModal" tabindex="-1" aria-labelledby="rulesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="rulesModalLabel">Quy Định Khi Tạo Tài Khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary">1. Quy định về ảnh đại diện:</h6>
                <ul>
                    <li>Tài khoản cần có <b>ảnh 3x4</b> khi tạo thủ công.</li>
                    <li>Ảnh phải có <b>nền trắng</b>, rõ mặt và đạt tiêu chuẩn.</li>
                </ul>

                <h6 class="text-primary">2. Quy định khi nhập qua Excel:</h6>
                <ul>
                    <li>Khi nhập tài khoản số lượng lớn qua file Excel, <b>không bắt buộc</b> phải có ảnh.</li>
                    <li>Sau khi tài khoản được tạo, quản trị viên có thể chỉnh sửa để bổ sung ảnh sau.</li>
                </ul>

                <h6 class="text-primary">3. Hướng dẫn bổ sung thông tin:</h6>
                <ul>
                    <li>Ảnh có thể được thêm vào sau tại trang <b>chỉnh sửa tài khoản</b>.</li>
                    <li>Đảm bảo mọi thông tin đầy đủ và chính xác để tránh lỗi trong quá trình sử dụng.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hiển thị modal ngay khi trang tải
        const rulesModal = new bootstrap.Modal(document.getElementById('rulesModal'));
        rulesModal.show();
    });
</script>

<style>
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        transform: translateY(-50px);
        opacity: 0;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }
</style>
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@endsection