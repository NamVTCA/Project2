<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý trường mẫu giáo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .alert {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
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

    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
        document.addEventListener('DOMContentLoaded', function() 
        {
            const fullnameInput = document.querySelector('input[name="fullname"]');
            if(fullnameInput) 
            {
                fullnameInput.addEventListener('input', function(e) 
                {
                    if(!/^[A-Za-z\s]*$/.test(this.value)) 
                    {
                        this.value = this.value.replace(/[^A-Za-z\s]/g, '');
                    }
                });
            }

            const numericInputs = document.querySelectorAll('input[name="phone"], input[name="idnumber"]');
            numericInputs.forEach(input => 
            {
                input.addEventListener('input', function(e) 
                {
                    if(!/^\d*$/.test(this.value)) 
                    {
                        this.value = this.value.replace(/\D/g, '');
                    }
                });
            });
        });
    </script>
</body>
</html>
