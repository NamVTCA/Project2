<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        .break-row td { background-color: #f0f0f0; font-style: italic; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Thời Khóa Biểu - Học Kỳ {{ $selectedSemester }}</h1>
    <table>
        <thead>
            <tr>
                <th>Tiết</th>
                <th>Thời gian</th>
                <th>Thứ 2</th>
                <th>Thứ 3</th>
                <th>Thứ 4</th>
                <th>Thứ 5</th>
                <th>Thứ 6</th>
                <th>Thứ 7</th>
            </tr>
        </thead>
        <tbody>
            @foreach($times as $period => $time)
                @if(str_contains($period, 'break'))
                    <tr class="break-row">
                        <td colspan="8">{{ $time }}</td>
                    </tr>
                @else
                    <tr>
                        <td>Tiết {{ is_numeric($period) ? $period : '' }}</td>
                        <td>{{ $time }}</td>
                        @for($day = 2; $day <= 7; $day++)
                            <td>{{ $schedule["t$day"]["p$period"] ?? '' }}</td>
                        @endfor
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
