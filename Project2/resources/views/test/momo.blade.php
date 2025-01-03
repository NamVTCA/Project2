    @extends('layouts.dashboard')

    @section('content')
    <div class="mb-3">
        <form action="{{ route('process_payment') }}" method="POST" id="payment_form">
            @csrf
            <link rel="stylesheet" href="{{ asset('css/Payment.css') }}">

            <!-- Nút quay về Dashboard -->
            <div class="back-to-dashboard">
                <button id="back-button" class="btn btn-secondary">← Quay về</button>
            </div>

            <!-- Chọn Trẻ -->
            <div class="mb-3">
                <label for="child_id" class="form-label text-pink">Chọn trẻ</label>
                <select class="form-select" id="child_id" name="child_id" required>
                    <option value="">-- Chọn trẻ --</option>
                    @foreach ($children as $child)
                        <option value="{{ $child->id }}">{{ $child->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tuition_id" class="form-label text-pink">Chọn kỳ học phí</label>
                <select class="form-select" id="tuition_id" name="tuition_id" disabled>
                    <option value="">-- Chọn kỳ học phí --</option>
                </select>
            </div>

            <div class="mb-3" id="tuition_details" style="display: none;">
                <h5>Chi tiết học phí</h5>
                <ul id="tuition_detail_list" class="list-group"></ul>
            </div>

            <!-- Lựa chọn phương thức thanh toán -->
            <div class="mb-3">
                <h5>Chọn phương thức thanh toán:</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo" required>
                    <label class="form-check-label" for="momo">
                        Thanh toán qua MoMo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" required>
                    <label class="form-check-label" for="stripe">
                        Thanh toán qua Stripe
                    </label>
                </div>
            </div>

            <!-- Nút thanh toán -->
            <input type="hidden" name="tuition_id" id="selected_tuition_id">
            <button type="submit" class="btn btn-pink w-100" disabled id="payment_button">Thanh toán</button>
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
                    tuitionSelect.innerHTML = `<option value="">-- Chọn kỳ học phí --</option>`;
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
                    tuitionSelect.innerHTML = `<option value="">-- Chọn kỳ học phí --</option>`;
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

        // Nút quay về
        document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
    </script>
    @endsection
