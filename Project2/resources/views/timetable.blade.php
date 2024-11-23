<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Timetable</title>
    <link rel="stylesheet" href="{{ asset('css/Timetable.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header Section -->
    <header class="py-3 shadow-sm" style="background-color: #ffe4e1;">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="title">NURSERY PRRSCHOOL</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Liên Hệ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1 class="page-title">Nursery Schedule</h1>

        <!-- Bộ lọc -->
        <div class="filter">
            <label for="date">Date</label>
            <input type="date" id="date">
            <label for="week">Tuần Thứ</label>
            <select id="week">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>

<!-- Thời gian biểu -->
<div class="timetable">
    <form id="timetable-form">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 8; $i++)
                <tr>
                    <th>{{ $i }}</th>
                    @for ($j = 1; $j <= 7; $j++)
                    <td><input type="text" name="slot[{{ $i }}][{{ $j }}]" placeholder="Label"></td>
                    @endfor
                </tr>
                @endfor
            </tbody>
        </table>
        <button type="submit" class="save-btn">Save Timetable</button>
    </form>
</div>
    </main>

    <script>
        document.getElementById('timetable-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch('{{ route('timetable.save') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>