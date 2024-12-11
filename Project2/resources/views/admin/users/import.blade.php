@extends('layouts.dashboard')

@section('title', 'Nhập dữ liệu người dùng từ Excel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nhập dữ liệu người dùng từ Excel</div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="file">Chọn file Excel:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Nhập dữ liệu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection