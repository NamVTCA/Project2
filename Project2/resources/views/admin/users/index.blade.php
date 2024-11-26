<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tài Khoản</title>
    <link rel="stylesheet" href="{{ asset('css/AccountManagement.css') }}">
</head>
<body>
    <div class="container">
        <h1>Quản Lý Tài Khoản</h1>

        <div class="actions">
            <!-- Chỉnh lại route -->
            <a href="{{ route('admin.users.create') }}" class="btn">Thêm Tài Khoản</a>
        </div>

        <table class="account-table">
            <thead>
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
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->email }}</td>
                        <td>{{ $account->id_number ?? '-' }}</td>
                        <td>{{ $account->active ? 'Hoạt Động' : 'Không Hoạt Động' }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $account->id) }}" class="btn btn-edit">Chi Tiết</a>
                            <form action="{{ route('admin.users.delete', $account->id) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</body>
</html>
