@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/Rules.css') }}">

<div class="rules-section py-5">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="text-primary fw-bold animate__animated animate__fadeInDown">Nội Quy Trường</h2>
            <p class="text-muted animate__animated animate__fadeIn">Hướng dẫn và quy định dành cho học sinh, phụ huynh và giáo viên.</p>
        </div>
        
        <div class="container py-5">
            <div class="section-header text-center mb-4">
                <h2 class="text-primary fw-bold animate__animated animate__fadeInDown">5 Điều Bác Hồ Dạy</h2>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Yêu Tổ quốc, yêu đồng bào.</li>
                    <li class="list-group-item">Học tập tốt, lao động tốt.</li>
                    <li class="list-group-item">Đoàn kết tốt, kỷ luật tốt.</li>
                    <li class="list-group-item">Giữ gìn vệ sinh thật tốt.</li>
                    <li class="list-group-item">Khiêm tốn, thật thà, dũng cảm.</li>
                </ol>
            </div>
        </div>

        <div class="rules-list">
            <!-- Rule 1 -->
            <div class="rule-card animate__animated animate__fadeInLeft">
                <h4 class="rule-title text-danger">1. Quy định về thời gian</h4>
                <p class="rule-description">
                    - Học sinh phải đến trường trước 7h30 sáng và ra về sau 16h00 chiều (trừ trường hợp đặc biệt).<br>
                    - Phụ huynh phải thông báo trước nếu không thể đón trẻ đúng giờ.
                </p>
            </div>

            <!-- Rule 2 -->
            <div class="rule-card animate__animated animate__fadeInRight">
                <h4 class="rule-title text-danger">2. Quy định về đồng phục</h4>
                <p class="rule-description">
                    - Học sinh phải mặc đồng phục đầy đủ khi đến trường.<br>
                    - Giữ gìn vệ sinh và sạch sẽ đồng phục trong suốt tuần học.
                </p>
            </div>

            <!-- Rule 3 -->
            <div class="rule-card animate__animated animate__fadeInLeft">
                <h4 class="rule-title text-danger">3. Quy định về an toàn</h4>
                <p class="rule-description">
                    - Không chạy nhảy, đùa nghịch ở cầu thang và khu vực nguy hiểm.<br>
                    - Báo cáo ngay với giáo viên khi phát hiện bất kỳ tình huống bất thường nào.
                </p>
            </div>

            <!-- Rule 4 -->
            <div class="rule-card animate__animated animate__fadeInRight">
                <h4 class="rule-title text-danger">4. Quy định về vệ sinh</h4>
                <p class="rule-description">
                    - Bỏ rác đúng nơi quy định, giữ vệ sinh chung trong lớp học và nhà vệ sinh.<br>
                    - Tham gia hoạt động giữ gìn môi trường xanh - sạch - đẹp.
                </p>
            </div>

            <!-- Rule 5 -->
            <div class="rule-card animate__animated animate__fadeInLeft">
                <h4 class="rule-title text-danger">5. Quy định về thái độ</h4>
                <p class="rule-description">
                    - Luôn tôn trọng giáo viên, bạn bè và nhân viên trong trường.<br>
                    - Không sử dụng ngôn ngữ không phù hợp hoặc hành động thiếu lịch sự.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
