<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="{{ asset('css/Feedback.css') }}">
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="{{ asset('img/Login.png') }}" alt="Nursery PreSchool" class="logo-image">
        </div>        
        <h1>Gửi Phản Hồi</h1>
        <form action="/feedback" method="POST">
            <div class="form-group">
                <label for="name">Tên của bạn</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" required>
            </div>
            <div class="form-group">
                <label for="email">Email liên hệ</label>
                <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
            </div>
            <div class="form-group">
                <label for="message">Phản hồi</label>
                <textarea id="message" name="message" rows="5" placeholder="Nhập phản hồi của bạn" required></textarea>
            </div>
            <button type="submit" class="btn">Gửi Phản Hồi</button>
        </form>

        <hr>

        <h2>Danh Sách Phản Hồi</h2>
        <ul class="feedback-list">
            <!-- Ví dụ phản hồi -->
            <li class="feedback-item">
                @if(Auth::check())
                <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                @endif
                <p>"Dịch vụ rất tốt, tôi rất hài lòng!"</p>
                <span class="timestamp">Gửi lúc: 2024-11-23 14:00</span>
            </li>
            <!-- Thêm phản hồi tại đây -->
        </ul>
    </div>
</body>
</html>
