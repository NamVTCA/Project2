@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Reposts.css') }}">
<div class="container">
    <h1>Thống Kê và Báo Cáo</h1>

    <div class="chart-container">
        <h3>Số Học Sinh Theo Lớp</h3>
        <canvas id="student-chart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Học Phí Theo Lớp</h3>
        <canvas id="revenue-chart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/Reports.js') }}"></script>
@endsection
