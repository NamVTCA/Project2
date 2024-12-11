@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Học Sinh từ Excel</div>

                <div class="card-body">
                    <form action="{{ route('admin.children.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="file">Chọn file Excel:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>

                    @if(session('import_errors'))
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach(session('import_errors') as $error)
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
@endsection