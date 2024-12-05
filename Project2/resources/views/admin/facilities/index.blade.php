@extends('layouts.dashboard')

@section('content')
<div class="facilities-index-page">
    <h2>Quản Lý Cơ Sở Vật Chất</h2>
    <a href="{{ route('facility_management.create') }}" class="btn btn-primary">Thêm Cơ Sở Vật Chất Mới</a>

    @foreach($totals as $total)
        <div class="total-facility">
            <h3>{{ $total->name }}</h3>
            <a href="{{ route('facility_management.edit', ['total' => $total->id]) }}" class="btn btn-warning">Chỉnh Sửa</a>
            <form action="{{ route('facility_management.destroy', ['total' => $total->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa</button>
            </form>
            
            <h5>Chi Tiết Cơ Sở Vật Chất</h5>
            <ul>
                @foreach($total->dentail as $dentail)
                    <li>{{ $dentail->name }} - Số lượng: {{ $dentail->quantity }} - Trạng thái: {{ $dentail->status }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
@endsection
