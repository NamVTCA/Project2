@extends('layouts.dashboard')

@section('title', 'Quản Lý Tài Khoản')

@section('content')
<div class="container account-management">
    <link rel="stylesheet" href="{{ asset('css/AccountManagement.css') }}">
    <h1>Quản Lý Tài Khoản</h1>

    <div class="actions mb-3">
        <!-- Chỉnh lại route -->
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm Tài Khoản</a>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Tên Đầy Đủ</th>
                <th>Email</th>
                <th>CCCD</th>
                <th>Trạng Thái</th>
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
                        <td>{{ $account->id_number ?? '-' }}</td>
                        <td>{{ $account->status ? 'Hoạt động' : 'Không Hoạt động' }}</td>
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
</div>
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection
