@extends('layouts.dashboard')

@section('title', 'Quản Lý Tài Khoản')

@section('content')
<div class="container account-management">
    <link rel="stylesheet" href="{{ asset('css/AccountManagement.css') }}">
    <h1>Quản Lý Tài Khoản</h1>

    <div class="actions mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Thêm Tài Khoản
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">Tạo một tài khoản</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">Tạo nhiều tài khoản</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.users.export') }}" class="btn btn-success">Xuất tệp Excel</a>
            <!-- Nút Delete All -->
    <form action="{{ route('admin.users.deleteAll') }}" method="POST" class="d-inline" id="delete-all-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa tất cả tài khoản?')">Xóa Tất Cả</button>
    </form>
    </div>
    <a href="{{ route('admin') }}" class="btn btn-secondary mb-3">← Quay về</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Tên Đầy Đủ</th>
                <th>Email</th>
                <th>Chức Vụ</th>
                <th>CCCD</th>
                <th>Số điện thoại</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                @if ($account->role != 0)
                    <tr>
                        <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ ($account->role)== 1?"Giáo Viên": "Phụ Huynh" }}</td>
                        <td>{{ $account->id_number ?? '-' }}</td>
                        <td>{{$account->phone}}</td>
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
    {{-- Thêm phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $accounts->links('vendor.pagination.default') }}
    </div>
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Tạo nhiều tài khoản bằng tệp ExcelExcel</h5>
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
                    {{-- Hiển thị lỗi validation --}}
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
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection