@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/Event.css') }}">

<div class="content-section">
    <section class="event-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5 animate__animated animate__fadeIn">
                <h2 class="text-primary fw-bold">Sự Kiện Trường Chúng Tôi </h2>
            </div>

            <div class="events-timeline">
                <!-- Event Card 1 -->
                <div class="event-card animate__animated animate__fadeInUp">
                    <div class="event-header">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/Pccc.jpg') }}" alt="PCCC activities">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/Pccc2.jpg') }}" alt="PCCC training">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">15/11/2024</div>
                        <h3>Tuyên Truyền Công Tác Phòng Cháy Chữa Cháy</h3>
                        <p class="event-description">
                            Hoạt động tuyên truyền về công tác PCCC giúp các bé hiểu được tầm quan trọng của việc phòng cháy chữa cháy, 
                            cách nhận biết các nguy cơ cháy nổ và biết cách ứng phó khi có sự cố xảy ra. Các bé được trực tiếp tham gia 
                            vào các hoạt động thực hành và trải nghiệm các tình huống giả định.
                        </p>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                    <div class="event-header">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport.jpg') }}" alt="Sports activities">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/sport2.jpg') }}" alt="Family sports">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">20/10/2024</div>
                        <h3>Ngày Hội Thể Thao Gia Đình 2024</h3>
                        <p class="event-description">
                            Ngày hội thể thao là dịp để các bé cùng gia đình tham gia các hoạt động vận động, rèn luyện sức khỏe. 
                            Các trò chơi được thiết kế phù hợp với lứa tuổi, tạo không khí vui tươi, sôi động và gắn kết tình cảm 
                            gia đình. Qua đó, các bé được phát triển kỹ năng vận động và tinh thần đồng đội.
                        </p>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="event-card animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                    <div class="event-header">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/culture2.jpg') }}" alt="Cultural performances">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('img/cultrure.jpg') }}" alt="Traditional activities">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">05/09/2024</div>
                        <h3>Ngày Hội Văn Hóa Dân Gian</h3>
                        <p class="event-description">
                            Ngày hội văn hóa dân gian là cơ hội để các bé được tìm hiểu về văn hóa truyền thống của dân tộc. 
                            Các em được trải nghiệm những trò chơi dân gian, thưởng thức các món ăn truyền thống và tham gia 
                            các hoạt động văn hóa đặc sắc. Qua đó, giúp các bé hiểu và yêu quý hơn về văn hóa dân tộc.
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
