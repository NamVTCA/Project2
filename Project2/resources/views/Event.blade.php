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
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/womenday1.jpg') }}" alt="Teacher's Day">
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
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/womenday2.jpg') }}" alt="Vietnamese Women's Day">
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
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/newyear.jpg') }}" alt="New Year Celebration">
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
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/trungthu.jpg') }}" alt="Mid-Autumn Festival">
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
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport.jpg') }}" alt="Children's Day">
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
                            Ngày Thể Thao Việt Nam được tổ chức nhằm khuyến khích phong trào thể dục thể thao trong cộng đồng. Đây là dịp để mọi người, đặc biệt là trẻ em và phụ huynh, cùng nhau tham gia các hoạt động thể thao bổ ích và vui vẻ
                        </p>
                    </div>
                </div>

                <!-- Event Card 6: National Day -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="1s">
                    <div class="event-header">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/nationalday.jpg') }}" alt="National Day">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">14/0202 hằng năm</div>
                        <h3>Ngày Hội Văn Hóa</h3>
                        <p class="event-description">
                            Ngày hội văn hóa dân tộc là một sự kiện đặc biệt nhằm giới thiệu và tôn vinh các giá trị văn hóa phong phú của các dân tộc trong nước. Sự kiện này không chỉ mang đến cho trẻ em những trải nghiệm thú vị mà còn giúp các em hiểu rõ hơn về bản sắc văn hóa dân tộc của quê hương
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swipers = document.querySelectorAll('.mySwiper');
        swipers.forEach(swiperElement => {
            new Swiper(swiperElement, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                }
            });
        });

        // Add animation on scroll
        const eventCards = document.querySelectorAll('.event-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        eventCards.forEach(card => {
            observer.observe(card);
        });
    });
</script>
@endsection
