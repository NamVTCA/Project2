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
                    <button class="btn btn-primary" onclick="toggleDetails()">Tìm Hiểu Thêm</button>
                </div>
            </div>

            <!-- Expandable Content -->
            <div id="additional-details" class="mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="school-details">
                            <h3 class="text-primary mb-4">Thông Tin Chi Tiết Về Trường</h3>
                            
                            <div class="detail-section mb-4">
                                <h4>Chương Trình Học Chi Tiết</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card">
                                            <h5>Lớp Mầm (3-4 tuổi)</h5>
                                            <div class="program-content">
                                                <h6>Phát triển thể chất</h6>
                                                <ul>
                                                    <li>Rèn luyện vận động thô: chạy, nhảy, leo trèo an toàn</li>
                                                    <li>Phát triển vận động tinh: tô màu, xếp hình, nặn đất sét</li>
                                                    <li>Các bài tập thể dục nhịp điệu vui nhộn</li>
                                                </ul>
            
                                                <h6>Phát triển ngôn ngữ</h6>
                                                <ul>
                                                    <li>Học từ vựng qua trò chơi và bài hát</li>
                                                    <li>Kể chuyện theo tranh</li>
                                                    <li>Làm quen với chữ cái và số</li>
                                                </ul>
            
                                                <h6>Kỹ năng xã hội</h6>
                                                <ul>
                                                    <li>Học cách chia sẻ và làm việc nhóm</li>
                                                    <li>Rèn luyện thói quen sinh hoạt cơ bản</li>
                                                    <li>Phát triển kỹ năng giao tiếp</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card">
                                            <h5>Lớp Chồi (4-5 tuổi)</h5>
                                            <div class="program-content">
                                                <h6>Phát triển tư duy</h6>
                                                <ul>
                                                    <li>Làm quen với các khái niệm toán học cơ bản</li>
                                                    <li>Phát triển tư duy logic qua trò chơi</li>
                                                    <li>Khám phá khoa học tự nhiên</li>
                                                </ul>
            
                                                <h6>Nghệ thuật sáng tạo</h6>
                                                <ul>
                                                    <li>Học vẽ và tô màu nâng cao</li>
                                                    <li>Làm đồ thủ công từ vật liệu tái chế</li>
                                                    <li>Học hát và múa theo nhạc</li>
                                                </ul>
            
                                                <h6>Kỹ năng sống</h6>
                                                <ul>
                                                    <li>Rèn luyện tính tự lập</li>
                                                    <li>Phát triển kỹ năng giải quyết vấn đề</li>
                                                    <li>Học cách bảo vệ bản thân</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card">
                                            <h5>Lớp Lá (5-6 tuổi)</h5>
                                            <div class="program-content">
                                                <h6>Chuẩn bị vào lớp 1</h6>
                                                <ul>
                                                    <li>Làm quen với chữ viết và số học</li>
                                                    <li>Rèn luyện kỹ năng đọc hiểu</li>
                                                    <li>Phát triển tư duy toán học</li>
                                                </ul>
            
                                                <h6>Phát triển ngôn ngữ nâng cao</h6>
                                                <ul>
                                                    <li>Học tiếng Anh cơ bản</li>
                                                    <li>Kỹ năng kể chuyện và thuyết trình</li>
                                                    <li>Phát triển vốn từ vựng phong phú</li>
                                                </ul>
            
                                                <h6>Kỹ năng xã hội nâng cao</h6>
                                                <ul>
                                                    <li>Làm việc nhóm hiệu quả</li>
                                                    <li>Rèn luyện tính kỷ luật</li>
                                                    <li>Phát triển sự tự tin</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-card">
                                            <h5>Chương Trình Ngoại Khóa</h5>
                                            <div class="program-content">
                                                <h6>Hoạt động thể thao</h6>
                                                <ul>
                                                    <li>Lớp bơi cơ bản (4-6 tuổi)</li>
                                                    <li>Yoga cho bé</li>
                                                    <li>Thể dục nhịp điệu</li>
                                                </ul>
            
                                                <h6>Nghệ thuật</h6>
                                                <ul>
                                                    <li>Lớp vẽ nâng cao</li>
                                                    <li>Đàn piano cơ bản</li>
                                                    <li>Múa ballet thiếu nhi</li>
                                                </ul>
            
                                                <h6>Hoạt động trải nghiệm</h6>
                                                <ul>
                                                    <li>Tham quan bảo tàng</li>
                                                    <li>Dã ngoại theo chủ đề</li>
                                                    <li>Trải nghiệm nghề nghiệp mini</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="detail-section mb-4">
                                <h4>Thời Gian Biểu Hàng Ngày</h4>
                                <div class="schedule-info">
                                    <div class="daily-schedule">
                                        <p><strong>07:30 - 08:05</strong> Đón trẻ và điểm tâm sáng</p>
                                        <p><strong>08:15 - 08:50</strong> Hoạt động học tập theo chủ đề</p>
                                        <p><strong>09:00 - 09:35</strong> Giờ ăn nhẹ và ra chơi</p>
                                        <p><strong>09:45 - 10:15</strong> Hoạt động ngoài trời</p>
                                        <p><strong>10:30 - 11:15</strong> Ăn trưa</p>
                                        <p><strong>11:45 - 13:00</strong> Ngủ trưa</p>
                                        <p><strong>13:30 - 14:05</strong> Hoạt động chiều</p>
                                        <p><strong>14:15 - 14:50</strong> Ăn xế</p>
                                        <p><strong>15:30 - 16:30</strong> Hoạt động tự do và trả trẻ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Your existing Facilities Section -->
    <section class="facilities-section py-5">
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

<script>
function toggleDetails() {
    const details = document.getElementById('additional-details');
    const button = event.target;
    
    if (!details.classList.contains('expanded')) {
        details.classList.add('expanded');
        button.innerHTML = 'Thu Gọn';
    } else {
        details.classList.remove('expanded');
        button.innerHTML = 'Tìm Hiểu Thêm';
    }
}
</script>
@endsection


