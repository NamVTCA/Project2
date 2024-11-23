@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Danh sách học sinh</h1>
        <a href="{{ route('children.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm học sinh
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>Phụ huynh</th>
                            <th>Lớp</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($children as $child)
                            <tr>
                                <td>
                                    <div class="avatar-sm">
                                        @if($child->img)
                                            <img src="{{ asset('storage/' . $child->img) }}" 
                                                 alt="{{ $child->name }}"
                                                 class="img-thumbnail rounded-circle">
                                        @else
                                            <div class="default-avatar rounded-circle">
                                                {{ strtoupper(substr($child->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $child->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($child->birthDate)->format('d/m/Y') }}</td>
                                <td>{{ $child->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                                <td>{{ $child->parent->name }}</td>
                                <td>{{ $child->classroom->name }}</td>
                                <td>
                                    <span class="badge {{ $child->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $child->status ? 'Đang học' : 'Đã nghỉ' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('children.show', $child) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('children.edit', $child) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger"
                                                onclick="confirmDelete({{ $child->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $children->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.avatar-sm img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.default-avatar {
    width: 100%;
    height: 100%;
    background: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}
</style>
@endsection