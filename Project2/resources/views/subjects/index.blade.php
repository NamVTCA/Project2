<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý môn học</title>
</head>
<body>
    <h1>Danh sách Môn học</h1>

    <!-- Hiển thị thông báo -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Form thêm mới -->
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tên môn học" required>
        <button type="submit">Thêm</button>
    </form>

    <h2>Danh sách:</h2>
    <ul>
        @foreach ($subjects as $subject)
            <li>
                {{ $subject->name }}
                <!-- Nút xóa -->
                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>