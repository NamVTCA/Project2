<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đội Ngũ Giảng Dạy</title>
    <link rel="stylesheet" href="{{ asset('css/Teachers.css') }}">
</head>
<body>
    <div class="container teachers-page">
        <h1 class="page-title">Đội Ngũ Giảng Dạy</h1>
        <div class="row">
            <!-- Teacher 1 -->
            <div class="col-md-4 teacher-card">
                <div class="card">
                    {{-- <img src="https://via.placeholder.com/250x250" class="card-img-top" alt="Ảnh của Nguyễn Văn A"> --}}
                    <div class="card-body">
                        <h5 class="card-title">Nguyễn Văn A</h5>
                        <p class="card-text"><strong>Chuyên môn:</strong> Toán Học</p>
                        <p class="card-text"><strong>Email:</strong> nguyenvana@example.com</p>
                        <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>

            <!-- Teacher 2 -->
            <div class="col-md-4 teacher-card">
                <div class="card">
                    {{-- <img src="https://via.placeholder.com/250x250" class="card-img-top" alt="Ảnh của Trần Thị B"> --}}
                    <div class="card-body">
                        <h5 class="card-title">Trần Thị B</h5>
                        <p class="card-text"><strong>Chuyên môn:</strong> Vật Lý</p>
                        <p class="card-text"><strong>Email:</strong> tranthib@example.com</p>
                        <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>

            <!-- Teacher 3 -->
            <div class="col-md-4 teacher-card">
                <div class="card">
                    {{-- <img src="https://via.placeholder.com/250x250" class="card-img-top" alt="Ảnh của Phạm Văn C"> --}}
                    <div class="card-body">
                        <h5 class="card-title">Phạm Văn C</h5>
                        <p class="card-text"><strong>Chuyên môn:</strong> Hóa Học</p>
                        <p class="card-text"><strong>Email:</strong> phamvanc@example.com</p>
                        <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
