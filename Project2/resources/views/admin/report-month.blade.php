<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Monthly Statistics</h1>
    <canvas id="monthlyChart" width="400" height="200"></canvas>
    <script>
        // Truyền dữ liệu từ Controller vào JavaScript
        const data = @json([
            'totalStudents' => $totalStudents,
            'newStudents' => $newStudents,
            'totalTeachers' => $totalTeachers,
            'newTeachers' => $newTeachers,
            'totalParents' => $totalParents,
            'newParents' => $newParents,
            'paidTuitions' => $paidTuitions,
            'feedbackCount' => $feedbackCount
        ]);

        const ctx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Total Students', 
                    'New Students', 
                    'Total Teachers', 
                    'New Teachers', 
                    'Total Parents', 
                    'New Parents', 
                    'Paid Tuitions', 
                    'Feedback'
                ],
                datasets: [{
                    label: 'Statistics for the Month',
                    data: [
                        data.totalStudents,
                        data.newStudents,
                        data.totalTeachers,
                        data.newTeachers,
                        data.totalParents,
                        data.newParents,
                        data.paidTuitions,
                        data.feedbackCount
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(99, 132, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(99, 132, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
