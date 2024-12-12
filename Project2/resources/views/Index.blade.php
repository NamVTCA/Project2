@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Home.css') }}">
<div class="content-section">
    <!-- Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('img/backtoschool.png') }}" class="img-fluid rounded shadow" alt="Importance of Pre-School Education">
                </div>
                <div class="col-md-6">
                    <h2 class="text-primary fw-bold">Giới Thiệu Về Trường</h2>
                    <p>Ngôi trường được xây dựng như ngôi nhà thứ hai của học sinh, mang lại môi trường học tập an toàn và phát triển toàn diện.</p>
                    <a href="#" class="btn btn-primary">Thông tin trường</a>
                </div>
            </div>
        </div>
    </section>

    <!-- School Information Section -->
    <section class="school-info-section py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 mb-4">
                    <a href="{{ route('linktoteacher') }}" class="hover-teachers text-reset text-decoration-none">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('img/family.png') }}" class="card-img-top mx-auto" alt="Teacher Icon" style="width: 50px;">
                            <div class="card-body">
                                <h3 class="card-title">Đội Ngũ Giảng Dạy</h3>
                                <p class="card-text">Bao gồm các giáo viên có chuyên môn và tận tâm chăm sóc các em.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 mb-4">
                    <a href="link-to-goals" class="hover-goals text-reset text-decoration-none">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('img/tam.png') }}" class="card-img-top mx-auto" alt="Goal Icon" style="width: 50px;">
                            <div class="card-body">
                                <h3 class="card-title">Mục Tiêu</h3>
                                <p class="card-text">Mang đến cho các em một môi trường học tập tốt nhất.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
