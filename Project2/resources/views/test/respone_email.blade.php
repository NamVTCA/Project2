<!-- resources/views/emails/tuition_payment.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn thanh toán học phí</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            margin-top: 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table, .content th, .content td {
            border: 1px solid #ddd;
        }
        .content th, .content td {
            padding: 8px;
            text-align: left;
        }
        .content th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Hóa đơn thanh toán học phí</h2>
        </div>

        <div class="content">
            <p><strong>Mã giao dịch:</strong> {{ $orderId }}</p>
            <p><strong>Học kỳ:</strong> {{ $semester }}</p>
            <p><strong>Tổng số tiền:</strong> {{ number_format($amount, 0, ',', '.') }} VNĐ</p>

            <h3>Chi tiết các mục thanh toán:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên mục</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $key)
                    <tr>
                        <td>{{ $key->name }}</td>
                        <td>{{ number_format($key->price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Trạng thái:</strong> Thành công</p>
            <p><strong>Thời gian giao dịch:</strong> {{ $transactionTime }}</p>
        </div>

        <div class="footer">
            <p>Trân trọng,</p>
            <p>Hệ thống nhà trường</p>
        </div>
    </div>
</body>
</html>
