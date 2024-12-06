@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Education.css') }}">
<div class="content-section">
    <section class="education-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('img/education.png') }}" class="img-fluid rounded shadow" alt="Preschool Education">
                </div>
                <div class="col-md-6">
                    <h2 class="text-primary fw-bold">Chương Trình Giáo Dục</h2>
                    <p>Tại trường chúng tôi, chương trình giáo dục được thiết kế để phát triển toàn diện các kỹ năng cần thiết cho sự phát triển của trẻ, bao gồm:</p>
                    <ul>
                        <li>Phát triển ngôn ngữ và giao tiếp</li>
                        <li>Kỹ năng tư duy và giải quyết vấn đề</li>
                        <li>Kỹ năng vận động và thể chất</li>
                        <li>Sự hiểu biết về thế giới xung quanh</li>
                    </ul>
                    <a href="#" class="btn btn-primary">Tìm Hiểu Thêm</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities-section py-5 bg-light">
        <div class="container">
            <h2 class="text-primary fw-bold text-center mb-4">Cơ Sở Vật Chất</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('img/classroom.png') }}" class="card-img-top" alt="Classroom">
                        <div class="card-body">
                            <h3 class="card-title">Phòng Học</h3>
                            <p class="card-text">Các phòng học được thiết kế thoáng mát, đầy đủ tiện nghi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('img/playground.png') }}" class="card-img-top" alt="Playground">
                        <div class="card-body">
                            <h3 class="card-title">Sân Chơi</h3>
                            <p class="card-text">Sân chơi rộng rãi, an toàn và đầy đủ các thiết bị vui chơi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('img/library.png') }}" class="card-img-top" alt="Library">
                        <div class="card-body">
                            <h3 class="card-title">Thư Viện</h3>
                            <p class="card-text">Thư viện đầy đủ sách và tài liệu học tập phong phú.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection