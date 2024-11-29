@extends('layouts.dashboard')

@section('title', 'Danh sách phản hồi')

@section('content')
<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/FeedbackList.css') }}">
    <h2 class="text-center">Danh sách phản hồi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($feedbacks->isEmpty())
        <div class="alert alert-warning">Không có phản hồi nào!</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Số Thứ Tự</th>
                    <th>Tên người gửi</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                    <th>Ngày gửi</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td>{{ $feedback->content }}</td>
                        <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
