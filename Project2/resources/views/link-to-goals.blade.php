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
                        Mục Tiêu 1: Phát Triển Xã Hội
                    </button>
                </h2>
                <div id="goal1Content" class="accordion-collapse collapse show" aria-labelledby="goal1Header" data-bs-parent="#goalsAccordion">
                    <div class="accordion-body">
                        Chúng tôi tập trung vào việc phát triển kỹ năng xã hội và cảm xúc của học sinh thông qua các hoạt động nhóm và tương tác với bạn bè.
                    </div>
                </div>
            </div>

            <!-- Mục tiêu 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="goal2Header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal2Content" aria-expanded="false" aria-controls="goal2Content">
                        Mục Tiêu 2: Tư Duy Logic
                    </button>
                </h2>
                <div id="goal2Content" class="accordion-collapse collapse" aria-labelledby="goal2Header" data-bs-parent="#goalsAccordion">
                    <div class="accordion-body">
                        Nâng cao khả năng tư duy logic và giải quyết vấn đề của trẻ thông qua các bài tập toán học, câu đố và các dự án sáng tạo.
                    </div>
                </div>
            </div>

            <!-- Mục tiêu 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="goal3Header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal3Content" aria-expanded="false" aria-controls="goal3Content">
                        Mục Tiêu 3: Phát Triển Thể Chất
                    </button>
                </h2>
                <div id="goal3Content" class="accordion-collapse collapse" aria-labelledby="goal3Header" data-bs-parent="#goalsAccordion">
                    <div class="accordion-body">
                        Hỗ trợ phát triển thể chất thông qua các hoạt động vui chơi ngoài trời, thể dục thể thao và các lớp học nhảy.
                    </div>
                </div>
            </div>

            <!-- Mục tiêu 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="goal4Header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#goal4Content" aria-expanded="false" aria-controls="goal4Content">
                        Mục Tiêu 4: Sáng Tạo Nghệ Thuật
                    </button>
                </h2>
                <div id="goal4Content" class="accordion-collapse collapse" aria-labelledby="goal4Header" data-bs-parent="#goalsAccordion">
                    <div class="accordion-body">
                        Phát triển kỹ năng nghệ thuật và sáng tạo của trẻ thông qua các lớp học vẽ, âm nhạc và thủ công.
                    </div>
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
