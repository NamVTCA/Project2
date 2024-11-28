<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Học Phí</title>
    <link rel="stylesheet" href="{{ asset('css/TuitionManagement.css') }}">
</head>
<body>
    <div class="container">
        <h1>Quản Lý Học Phí</h1>

        <div class="actions">
            <a href="{{ route('tuition.create') }}" class="btn">Tạo Học Phí</a>
        </div>

        <form method="GET" action="{{ route('tuition.index') }}">
            <div class="form-group">
                <label for="classroom_id">Chọn Lớp</label>
                <select name="classroom_id" id="classroom_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Chọn lớp --</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" 
                                {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="children_id">Chọn Học Sinh</label>
                <select name="children_id" id="children_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Chọn học sinh --</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}" 
                                {{ request('children_id') == $child->id ? 'selected' : '' }}>
                            {{ $child->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if($selectedChild)
            <div class="child-info">
                <h3>Thông Tin Trẻ</h3>
                <p><strong>Tên Phụ Huynh:</strong> {{ $selectedChild->user->name }}</p>
                <p><strong>Ngày Sinh:</strong> {{ $selectedChild->birthDate }}</p>
                <p><strong>Giới Tính:</strong> {{ $selectedChild->gender == 'male' ? 'Nam' : 'Nữ' }}</p>
            </div>

            <table class="tuition-table">
                <thead>
                    <tr>
                        <th>Kỳ Học</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($selectedChild->tuition as $tuition)
                        <tr>
                            <td>{{ $tuition->semester }}</td>
                            <td>{{ $tuition->status ? 'Đã Đóng' : 'Chưa Đóng' }}</td>
                            <td>
                                <a href="{{ route('tuition.edit', $tuition->id) }}" class="btn btn-primary">Cập Nhật</a>
                            </td>
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
</body>
</html>
