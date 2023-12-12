<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart</title>
</head>
<body>
    <div style="width: 80%; margin: auto;">
        <canvas id="myPieChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var data = <?php echo json_encode($data); ?>;

        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                    ],
                }],
            },
        });
    </script>
</body>
</html>
