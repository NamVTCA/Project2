@extends('layouts.dashboard')

@section('title', 'Danh Sách Học Sinh trong Lớp')
<link rel="stylesheet" href="{{ asset('css/ChildClass.css') }}">
@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Danh Sách Học Sinh trong Lớp</h2>

        <div class="table-responsive mt-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Học Sinh</th>
                        <th>Lớp Học</th>
                        <th>Ngày Thêm</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($childclasses as $childclass)
                        <tr>
                            <td>{{ $childclass->child->name }}</td>
                            <td>{{ $childclass->classroom->name }}</td>
                            <td>{{ $childclass->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('childclass.edit', ['child_id' => $childclass->child_id, 'classroom_id' => $childclass->classroom_id]) }}" class="btn btn-warning btn-sm">Chỉnh Sửa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
