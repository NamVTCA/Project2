<!-- resources/views/payment.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Học Phí</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Thanh Toán Học Phí</h2>
        <form action="{{route('momo_payment')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tuition_id" class="form-label">Chọn kỳ học phí</label>
                <select class="form-select" id="tuition_id" name="tuition_id" required>
                     @foreach ($tuitions as $tuition)
            @if ($tuition->status === 0)
                <option value="{{ $tuition->id }}">
                    Học phí kỳ {{ $tuition->semester }} - {{ number_format($tuition->tuition_info->sum('price')) }} VNĐ
                </option>
            @else
                <option value="{{ $tuition->id }}" disabled>
                    Học phí kỳ {{ $tuition->semester }} - {{ number_format($tuition->tuition_info->sum('price')) }} VNĐ (Đã thanh toán)
                </option>
            @endif
        @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Thanh Toán</button>
        </form>
    </div>
</body>
</html>
