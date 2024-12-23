@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/Event.css') }}">

<div class="content-section">
    <section class="event-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5 animate__animated animate__fadeIn">
                <h2 class="text-primary fw-bold">Sự Kiện Hằng Năm</h2>
            </div>

            <div class="events-timeline">
                <!-- Event Card 1: Teacher's Day -->
                <div class="event-card animate__animated animate__fadeInUp">
                    <div class="event-header">
                        <div class="swiper swiper1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event11.jpg') }}" alt="Teacher's Day">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event12.jpg') }}" alt="Teacher's Day 2">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event13.jpg') }}" alt="Teacher's Day 3">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">20/11 hằng năm</div>
                        <h3>Ngày Nhà Giáo Việt Nam</h3>
                        <p class="event-description">
                            Ngày Nhà Giáo Việt Nam (20/11) là một dịp đặc biệt để học sinh và toàn xã hội tri ân, tôn vinh những người thầy, người cô đã cống hiến cho sự nghiệp giáo dục. Đây là ngày để ghi nhận những nỗ lực và tâm huyết của các nhà giáo trong việc dạy dỗ, hướng dẫn và định hình tương lai của thế hệ trẻ
                        </p>
                    </div>
                </div>

                <!-- Event Card 2: Vietnamese Women's Day -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                    <div class="event-header">
                        <div class="swiper swiper2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event21.jpg') }}" alt="Vietnamese Women's Day">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event22.jpg') }}" alt="Vietnamese Women's Day 2">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event23.jpg') }}" alt="Vietnamese Women's Day 3">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">20/10 hằng năm</div>
                        <h3>Ngày Phụ Nữ Việt Nam</h3>
                        <p class="event-description">
                            Ngày Phụ Nữ Việt Nam (20/10) là dịp để tôn vinh những đóng góp và vai trò quan trọng của phụ nữ trong gia đình và xã hội. Đây là ngày để ghi nhận những nỗ lực, sự hy sinh và cống hiến của phụ nữ trong mọi lĩnh vực, từ công việc gia đình đến sự nghiệp và các hoạt động xã hội
                        </p>
                    </div>
                </div>

                <!-- Event Card 3: New Year -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                    <div class="event-header">
                        <div class="swiper swiper3">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event31.jpg') }}" alt="New Year Celebration">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event32.jpg') }}" alt="New Year Celebration 2">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event33.jpg') }}" alt="New Year Celebration 3">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">01/01 hằng năm</div>
                        <h3>Tết Dương Lịch</h3>
                        <p class="event-description">
                            Tết Dương Lịch, hay còn gọi là Ngày đầu năm mới (1/1), là dịp để mọi người trên khắp thế giới cùng nhau chào đón một năm mới với nhiều hy vọng và ước mơ. Đây là thời điểm để mọi người sum vầy bên gia đình, bạn bè, và gửi đến nhau những lời chúc tốt đẹp
                            Trong không khí Tết, món ăn không thể thiếu chính là bánh chưng. Để giáo dục trẻ về truyền thống văn hóa, cô giáo sẽ tổ chức hoạt động dạy các bé gói bánh chưng
                        </p>
                    </div>
                </div>

                <!-- Event Card 4: Mid-Autumn Festival -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                    <div class="event-header">
                        <div class="swiper swiper4">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event41.jpg') }}" alt="Mid-Autumn Festival">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event42.jpg') }}" alt="Mid-Autumn Festival 2">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/event43.jpg') }}" alt="Mid-Autumn Festival 3">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">15/08 hằng năm</div>
                        <h3>Tết Trung Thu</h3>
                        <p class="event-description">
                            Tết Trung Thu, hay còn gọi là Tết Trông Trăng, diễn ra vào rằm tháng Tám âm lịch. Đây là một trong những ngày lễ truyền thống quan trọng nhất ở Việt Nam, đặc biệt dành cho trẻ em. Một trong những hoạt động thú vị trong dịp này là dạy trẻ làm bánh trung thu
                        </p>
                    </div>
                </div>

                <!-- Event Card 5: Children's Day -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.8s">
                    <div class="event-header">
                        <div class="swiper swiper5">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport.jpg') }}" alt="Children's Day">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport2.jpg') }}" alt="Children's Day 2">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport3.jpg') }}" alt="Children's Day 3">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">27/03 hằng năm</div>
                        <h3>Ngày Thể Thao Việt Nam</h3>
                        <p class="event-description">
                            Ngày hội thể thao là dịp để các bé cùng gia đình tham gia các hoạt động vận động, rèn luyện sức khỏe. 
                            Các trò chơi được thiết kế phù hợp với lứa tuổi, tạo không khí vui tươi, sôi động và gắn kết tình cảm 
                            gia đình. Qua đó, các bé được phát triển kỹ năng vận động và tinh thần đồng đội.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Khởi tạo Swiper cho từng phần swiper riêng biệt
    var swiper1 = new Swiper('.swiper1', {
        autoplay: {
            delay: 3000, // Tự động chuyển ảnh sau 3 giây
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true, // Cho phép nhấn vào phân trang
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper2 = new Swiper('.swiper2', {
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper3 = new Swiper('.swiper3', {
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper4 = new Swiper('.swiper4', {
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper5 = new Swiper('.swiper5', {
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
@endsection
