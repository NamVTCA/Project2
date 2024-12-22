<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mục Tiêu Liên Kết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Goals.css') }}">
</head>
<body>
    <div class="container goals-page">

        <h1 class="page-title">Liên Kết Đến Mục Tiêu</h1>

        <p class="intro-text">
            Dưới đây là các mục tiêu chính mà chúng tôi hướng đến. Nhấn vào từng mục tiêu để xem chi tiết!
        </p>
        <div class="back-to-dashboard">
            <button id="back-button" class="btn btn-secondary">← Quay về</button>
        </div>

<!-- Accordion -->
<div class="accordion" id="goalsAccordion">
    <!-- Mục tiêu 1 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal1Header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#goal1Content" aria-expanded="true" aria-controls="goal1Content">
                Mục Tiêu 1: Phát triển thể chất
            </button>
        </h2>
        <div id="goal1Content" class="accordion-collapse collapse show" aria-labelledby="goal1Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Khuyến khích các hoạt động vận động giúp trẻ khỏe mạnh, nhanh nhẹn, và dẻo dai.</li>
                <li>Rèn luyện kỹ năng vận động cơ bản như chạy, nhảy, leo trèo, và kỹ năng vận động tinh như cầm nắm, viết, và vẽ.</li>
                <li>Hình thành thói quen vệ sinh cá nhân và bảo vệ sức khỏe.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 2 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal2Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal2Content" aria-expanded="false" aria-controls="goal2Content">
                Mục Tiêu 2: Phát triển nhận thức
            </button>
        </h2>
        <div id="goal2Content" class="accordion-collapse collapse" aria-labelledby="goal2Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Khơi dậy sự tò mò, khám phá thế giới xung quanh.</li>
                <li>Dạy trẻ nhận biết và phân biệt các màu sắc, hình dạng, con số, chữ cái.</li>
                <li>Phát triển kỹ năng giải quyết vấn đề và tư duy logic thông qua các trò chơi và hoạt động học tập.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 3 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal3Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal3Content" aria-expanded="false" aria-controls="goal3Content">
                Mục Tiêu 3: Phát triển ngôn ngữ
            </button>
        </h2>
        <div id="goal3Content" class="accordion-collapse collapse" aria-labelledby="goal3Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Khuyến khích trẻ giao tiếp, diễn đạt ý tưởng và cảm xúc bằng lời nói.</li>
                <li>Mở rộng vốn từ vựng thông qua kể chuyện, hát, và các hoạt động học tập.</li>
                <li>Giúp trẻ làm quen với việc đọc và viết ở mức độ cơ bản.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 4 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal4Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal4Content" aria-expanded="false" aria-controls="goal4Content">
                Mục Tiêu 4: Phát triển tình cảm và xã hội
            </button>
        </h2>
        <div id="goal4Content" class="accordion-collapse collapse" aria-labelledby="goal4Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Hướng dẫn trẻ cách chia sẻ, hợp tác, và làm việc nhóm với bạn bè.</li>
                <li>Giúp trẻ phát triển cảm xúc tích cực, biết yêu thương, tôn trọng, và đồng cảm với người khác.</li>
                <li>Hình thành sự tự tin, tự lập và khả năng quản lý cảm xúc.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 5 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal5Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal5Content" aria-expanded="false" aria-controls="goal5Content">
                Mục Tiêu 5: Phát triển thẩm mỹ
            </button>
        </h2>
        <div id="goal5Content" class="accordion-collapse collapse" aria-labelledby="goal5Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Nuôi dưỡng sự sáng tạo và cảm nhận nghệ thuật qua các hoạt động như vẽ, múa, hát, và làm đồ thủ công.</li>
                <li>Khuyến khích trẻ thể hiện bản thân và cảm nhận cái đẹp từ thiên nhiên và cuộc sống.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 6 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal6Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal6Content" aria-expanded="false" aria-controls="goal6Content">
                Mục Tiêu 6: Giáo dục đạo đức
            </button>
        </h2>
        <div id="goal6Content" class="accordion-collapse collapse" aria-labelledby="goal6Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Hình thành các giá trị đạo đức cơ bản như lễ phép, trung thực, tôn trọng, và giúp đỡ người khác.</li>
                <li>Hướng dẫn trẻ biết giữ gìn và bảo vệ môi trường xung quanh.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 7 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal7Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal7Content" aria-expanded="false" aria-controls="goal7Content">
                Mục Tiêu 7: Phát triển kỹ năng sống
            </button>
        </h2>
        <div id="goal7Content" class="accordion-collapse collapse" aria-labelledby="goal7Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Rèn luyện kỹ năng tự phục vụ như tự ăn, tự mặc, và chăm sóc bản thân.</li>
                <li>Giúp trẻ học cách ra quyết định và xử lý các tình huống đơn giản trong cuộc sống.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 8 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal8Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal8Content" aria-expanded="false" aria-controls="goal8Content">
                Mục Tiêu 8: Kích thích tư duy sáng tạo
            </button>
        </h2>
        <div id="goal8Content" class="accordion-collapse collapse" aria-labelledby="goal8Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Khuyến khích trẻ đặt câu hỏi, suy nghĩ độc lập và tìm ra những cách mới để giải quyết vấn đề.</li>
                <li>Tạo điều kiện cho trẻ tham gia các hoạt động sáng tạo như xây dựng mô hình, kể chuyện sáng tạo, và các trò chơi tưởng tượng.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 9 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal9Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal9Content" aria-expanded="false" aria-controls="goal9Content">
                Mục Tiêu 9: Khám phá và bảo vệ môi trường
            </button>
        </h2>
        <div id="goal9Content" class="accordion-collapse collapse" aria-labelledby="goal9Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Hướng dẫn trẻ giữ gìn và bảo vệ môi trường xung quanh.</li>
                <li>Thực hiện các hoạt động như trồng cây, phân loại rác, và tiết kiệm tài nguyên.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 10 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal10Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal10Content" aria-expanded="false" aria-controls="goal10Content">
                Mục Tiêu 10: Chuẩn bị hành trang vào tiểu học
            </button>
        </h2>
        <div id="goal10Content" class="accordion-collapse collapse" aria-labelledby="goal10Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Giúp trẻ làm quen với môi trường học tập và các quy tắc lớp học.</li>
                <li>Phát triển kỹ năng tập trung, làm việc độc lập và tự tin trước khi vào lớp 1.</li>
            </div>
        </div>
    </div>

    <!-- Mục tiêu 11 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="goal11Header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal11Content" aria-expanded="false" aria-controls="goal11Content">
                Mục Tiêu 11: Giáo dục đạo đức
            </button>
        </h2>
        <div id="goal11Content" class="accordion-collapse collapse" aria-labelledby="goal11Header" data-bs-parent="#goalsAccordion">
            <div class="accordion-body">
                <li>Hình thành các giá trị đạo đức cơ bản như lễ phép, trung thực, tôn trọng, và giúp đỡ người khác.</li>
                <li>Giúp trẻ biết yêu thương và đồng cảm với mọi người xung quanh.</li>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.getElementById('back-button').addEventListener('click', function () {
        window.history.back();
    });
</script>
</body>
</html>
