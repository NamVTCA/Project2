<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <header class="py-3 shadow-sm bg-light">
        <div class="container">
            <h1 class="text-primary">Nursery PreSchool</h1>
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link text-danger">Đăng Xuất</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mt-4">
        @yield('content')
    </main>
</body>
</html>
