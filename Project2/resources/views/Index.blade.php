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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#schoolInfoModal">Thông tin trường</a>

                    <!-- Modal -->
                    <div class="modal fade" id="schoolInfoModal" tabindex="-1" aria-labelledby="schoolInfoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="schoolInfoModalLabel">Thông tin trường học</h5>
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                </div>
                                <div class="modal-body">
                                    <h3 class="fw-bold">Thông Tin Chi Tiết</h3>
                                    <p>Trường được thành lập với mục tiêu tạo ra một môi trường giáo dục toàn diện, nơi học sinh được phát triển cả về kiến thức và kỹ năng sống.</p>
                                    <ul>
                                        <li><strong>Địa chỉ:</strong> The Emporium Tower, 184 Đ. Lê Đại Hành, Phường 15, Quận 11, Hồ Chí Minh</li>
                                        <li><strong>Năm thành lập:</strong> 2010</li>
                                        <li><strong>Chương trình đào tạo:</strong> Hệ thống giáo dục chuẩn quốc tế.</li>
                                        <li><strong>Cơ sở vật chất:</strong> Hiện đại, khang trang, đáp ứng đầy đủ nhu cầu học tập.</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- School Information Section -->
    <section class="school-info-section py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 mb-4">
                    <a href="{{ route('teachers') }}" class="hover-teachers text-reset text-decoration-none">
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
                    <a href="{{ route('link-to-goals') }}" class="hover-goals text-reset text-decoration-none">
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
