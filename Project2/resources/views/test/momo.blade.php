@extends('layouts.dashboard')

@section('content')
<div class="container my-5 payment-page">
    <link rel="stylesheet" href="{{ asset('css/Payment.css') }}">
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
@endsection

@section('scripts')
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
@endsection
