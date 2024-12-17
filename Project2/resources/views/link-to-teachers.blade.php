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
            @foreach ($teachers as $teacher)
                <div class="col-md-4 teacher-card">
                    <div class="card">
                        @if ($teacher->img)
                            <img src="{{ asset('storage/' . $teacher->img) }}" class="card-img-top" alt="Ảnh của {{ $teacher->name }}">
                        @else
                            <img src="https://via.placeholder.com/250x250" class="card-img-top" alt="Ảnh của {{ $teacher->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher->name }}</h5>
                            <p class="card-text"><strong>Email:</strong> {{ $teacher->email }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>