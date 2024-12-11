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
                <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">Tạo một User</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">Tạo nhiều User</a></li>
            </ul>
        </div>
        <a href="{{ route('admin.users.export') }}" class="btn btn-success">Xuất Excel</a>
    </div>

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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ ($account->role)== 1?"Giáo Viên": "Phụ Huynh" }}</td>
                        <td>{{ $account->id_number ?? '-' }}</td>
                        <td>{{$account->phone}}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $account->id) }}" class="btn btn-sm btn-info">Chi Tiết</a>
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
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Users từ Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
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
                                @foreach(session('import_errors') as $errorRow)
                                    @if(isset($errorRow['errors']['vai_tro']) || isset($errorRow['errors']['trang_thai']))
                                        <li>
                                            <strong>Dòng {{ $errorRow['row']['#'] }}:</strong>
                                            @if(isset($errorRow['errors']['vai_tro']))
                                                {{ $errorRow['errors']['vai_tro'][0] }}
                                            @endif
                                            @if(isset($errorRow['errors']['trang_thai']))
                                                {{ $errorRow['errors']['trang_thai'][0] }}
                                            @endif
                                        </li>
                                    @endif
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