@extends('layouts.dashboard')

@section('title', 'Quản Lý Tài Khoản')

@section('content')
<div class="container account-management">
    <link rel="stylesheet" href="{{ asset('css/AccountManagement.css') }}">
    <h1>Quản lý tài khoản</h1>

    <div class="actions mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Thêm tài khoản
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">Tạo một tài khoản</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">Tạo nhiều tài khoản</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.users.export') }}" class="btn btn-success">Xuất tệp Excel</a>
        <form action="{{ route('admin.users.deleteAll') }}" method="POST" class="d-inline" id="delete-all-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa tất cả tài khoản?')">Xóa Tất Cả</button>
        </form>
    </div>
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <!-- Thêm bộ lọc -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3 d-flex align-items-center gap-3">
        <label for="role-filter" class="form-label mb-0"><strong>Lọc vai trò:</strong></label>
        <select name="role" id="role-filter" class="form-select" onchange="this.form.submit()">
            <option value="" {{ request('role') === null ? 'selected' : '' }}>Tất cả</option>
            <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Giáo viên</option>
            <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Phụ huynh</option>
        </select>
    </form>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Tên đầy đủ</th>
                <th>Email</th>
                <th>Chức vụ</th>
                <th>CCCD</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                @if ($account->role != 0)
                    <tr>
                        <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ $account->role == 1 ? 'Giáo viên' : 'Phụ huynh' }}</td>
                        <td>{{ $account->id_number ?? '-' }}</td>
                        <td>{{ $account->phone }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $account->id) }}" class="btn btn-sm btn-info">Sửa thông tin</a>
                            <form action="{{ route('admin.users.delete', $account->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $accounts->links('vendor.pagination.default') }}
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Tạo nhiều tài khoản bằng tệp Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Chọn tệp Excel</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Nhập</button>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
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
