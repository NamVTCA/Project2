@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm học sinh mới</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthDate">Ngày sinh</label>
                            <input type="date" 
                                   class="form-control @error('birthDate') is-invalid @enderror" 
                                   id="birthDate" 
                                   name="birthDate" 
                                   value="{{ old('birthDate') }}" 
                                   required>
                            @error('birthDate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender">Giới tính</label>
                            <select class="form-control @error('gender') is-invalid @enderror" 
                                    id="gender" 
                                    name="gender" 
                                    required>
                                <option value="">Chọn giới tính</option>
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Nam</option>
                                <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userId">Phụ huynh</label>
                            <select class="form-control @error('userId') is-invalid @enderror" 
                                    id="userId" 
                                    name="userId" 
                                    required>
                                <option value="">Chọn phụ huynh</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ old('userId') == $user->id ? 'selected' : '' }}>
                                        {{ $user->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('userId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="classroom_id">Lớp</label>
                            <select class="form-control @error('classroom_id') is-invalid @enderror" 
                                    id="classroom_id" 
                                    name="classroom_id" 
                                    required>
                                <option value="">Chọn lớp</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" 
                                            {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                        {{ $classroom->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classroom_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Đang học</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Đã nghỉ</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="img">Ảnh</label>
                            <input type="file" 
                                   class="form-control @error('img') is-invalid @enderror" 
                                   id="img" 
                                   name="img"
                                   accept="image/*">
                            @error('img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="note">Ghi chú</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" 
                                      name="note" 
                                      rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Thêm học sinh</button>
                    <a href="{{ route('children.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection