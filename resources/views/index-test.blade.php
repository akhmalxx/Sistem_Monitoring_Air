<!DOCTYPE html>
<html>

<head>
    <title>Sensor Flow Rate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            margin-top: 0;
        }

        canvas {
            max-width: 800px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Data Sensor dari Firebase</h2>
    <p><strong>Flow Rate:</strong> <span id="flowRate">{{ number_format($flowRate, 2) }}</span> L/min</p>
    <p><strong>Total Volume:</strong> <span id="totalML">{{ number_format($totalML, 0) }}</span> mL</p>

    <canvas id="flowChart"></canvas>

    <script>
        const flowRateDisplay = document.getElementById('flowRate');
        const totalMLDisplay = document.getElementById('totalML');

        let chartData = {
            labels: [],
            datasets: [{
                label: 'Flow Rate (L/min)',
                data: [],
                borderColor: 'rgba(0, 123, 255, 1)',
                fill: false,
                tension: 0.1
            }]
        };

        const ctx = document.getElementById('flowChart').getContext('2d');
        const flowChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                animation: false,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Waktu'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'L/min'
                        }
                    }
                }
            }
        });

        function updateChart(flowRate) {
            const now = new Date().toLocaleTimeString();

            if (chartData.labels.length >= 10) {
                chartData.labels.shift();
                chartData.datasets[0].data.shift();
            }

            chartData.labels.push(now);
            chartData.datasets[0].data.push(flowRate);

            flowChart.update();
        }

        // Realtime polling: ambil data dari endpoint Laravel setiap 2 detik
        setInterval(() => {
            fetch('{{ url('/api/sensor/data') }}')
                .then(response => response.json())
                .then(data => {
                    flowRateDisplay.textContent = parseFloat(data.flowRate).toFixed(1);
                    totalMLDisplay.textContent = parseFloat(data.totalML).toFixed(0);
                    updateChart(parseFloat(data.flowRate));
                })
                .catch(error => console.error("Gagal fetch:", error));
        }, 2000);
    </script>
</body>

</html>
