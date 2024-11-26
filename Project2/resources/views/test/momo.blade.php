<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Học Phí</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Payment.css') }}">
</head>
<body>
    <!-- Header Section -->
        <header class="bg-light py-3 shadow-sm">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="title">NURSERY PRESCHOOL</div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Trang Chủ</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Sự Kiện</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Giáo Dục</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('feedback')}}">Phản Hồi</a></li>
                            <li class="nav-item">
                                @if(Auth::check())
                                    <!-- Hiển thị "Đăng Xuất" nếu người dùng đã đăng nhập -->
                                    <a class="nav-link" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng Xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <!-- Hiển thị "Đăng Nhập" nếu người dùng chưa đăng nhập -->
                                    <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    <div class="container my-5">
        <h2 class="text-center text-pink">Thanh Toán Học Phí</h2>
        <div class="mb-3">
            <label for="child_id" class="form-label text-pink">Chọn Trẻ</label>
            <select class="form-select" id="child_id" name="child_id" required>
                <option value="">-- Chọn Trẻ --</option>
                @foreach ($children as $child)
                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tuition_id" class="form-label text-pink">Chọn Kỳ Học Phí</label>
            <select class="form-select" id="tuition_id" name="tuition_id" disabled>
                <option value="">-- Chọn Kỳ Học Phí --</option>
            </select>
        </div>

        <div class="mb-3" id="tuition_details" style="display: none;">
            <h5>Chi Tiết Học Phí</h5>
            <ul id="tuition_detail_list" class="list-group"></ul>
        </div>

        <form action="{{ route('momo_payment') }}" method="POST">
            @csrf
            <input type="hidden" name="tuition_id" id="selected_tuition_id">
            <button type="submit" class="btn btn-pink w-100" disabled id="payment_button">Thanh Toán</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       document.addEventListener("DOMContentLoaded", () => {
    const childSelect = document.getElementById("child_id");
    const tuitionSelect = document.getElementById("tuition_id");
    const tuitionDetails = document.getElementById("tuition_details");
    const tuitionDetailList = document.getElementById("tuition_detail_list");
    const paymentButton = document.getElementById("payment_button");
    const selectedTuitionIdInput = document.getElementById("selected_tuition_id");

    const tuitions = @json($tuitions); 

    childSelect.addEventListener("change", () => {
        const childId = childSelect.value;

        if (childId) {

            const filteredTuitions = tuitions.filter(tuition => tuition.child_id == childId);

            tuitionSelect.innerHTML = `<option value="">-- Chọn Kỳ Học Phí --</option>`;
            filteredTuitions.forEach(tuition => {
                const option = document.createElement("option");
                option.value = tuition.id;
                option.textContent = `Học phí kỳ ${tuition.semester} - ${tuition.tuition_info.reduce((sum, info) => sum + info.price, 0).toLocaleString()} VNĐ`;


                if (tuition.status === 1) {
                    option.textContent += " (Đã thanh toán)";
                    option.disabled = true; 
                }
                tuitionSelect.appendChild(option);
            });

            tuitionSelect.disabled = false;
            tuitionDetails.style.display = "none";
            paymentButton.disabled = true;
        } else {
            tuitionSelect.innerHTML = `<option value="">-- Chọn Kỳ Học Phí --</option>`;
            tuitionSelect.disabled = true;
            tuitionDetails.style.display = "none";
            paymentButton.disabled = true;
        }
    });

    tuitionSelect.addEventListener("change", () => {
        const tuitionId = tuitionSelect.value;

        if (tuitionId) {

            const selectedTuition = tuitions.find(tuition => tuition.id == tuitionId);
            const details = selectedTuition ? selectedTuition.tuition_info : [];

            tuitionDetailList.innerHTML = "";
            details.forEach(detail => {
                const listItem = document.createElement("li");
                listItem.className = "list-group-item";
                listItem.textContent = `Mục: ${detail.name} - Giá: ${detail.price.toLocaleString()} VNĐ`;
                tuitionDetailList.appendChild(listItem);
            });

            tuitionDetails.style.display = "block";
            paymentButton.disabled = false;
            selectedTuitionIdInput.value = tuitionId;
        } else {
            tuitionDetails.style.display = "none";
            paymentButton.disabled = true;
        }
    });
});
    </script>
</body>
</html>
