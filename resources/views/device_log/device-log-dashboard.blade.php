@extends('layouts.app')

@section('title', 'Blank Page')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Blank Page</h1>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="row d-flex align-items-stretch">
                    <!-- Card Kiri -->
                    <div class="col-md-4 mb-2 d-flex">
                        <div class="card w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Card Action Button</h4>
                            </div>

                            <div class="card-body flex-grow-1">
                                <form method="GET" action="{{ route('device.log') }}">
                                    <div class="form-group">
                                        <label for="deviceSelect">Pilih Device</label>
                                        <select class="custom-select" id="deviceSelect" name="device_id" required
                                            onchange="this.form.submit()">
                                            <option disabled {{ is_null(request('device_id')) ? 'selected' : '' }}>Pilih
                                                Device</option>
                                            @foreach ($devices as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ request('device_id') == $d->id ? 'selected' : '' }}>
                                                    {{ $d->user->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>


                                <div class="form-group">
                                    <label for="monthPicker">Pilih Bulan</label>
                                    <input type="month" id="monthPicker" class="form-control" value="{{ date('Y-m') }}">
                                </div>
                            </div>
                            {{-- @if (!is_null($device))
                                <div class="card-body">
                                    <h2>Data untuk Device: {{ $device->user->username }}</h2>

                                    <h4>Flow Sensor</h4>
                                    <pre>{{ json_encode($flowData, JSON_PRETTY_PRINT) }}</pre>

                                    <h4>Riwayat</h4>
                                    <pre>{{ json_encode($history, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            @endif --}}
                        </div>
                    </div>

                    <!-- Card Chart -->
                    <div class="col-md-8 mb-2 d-flex">
                        <div class="card w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Grafik Pemakaian Air</h4>
                            </div>

                            <div class="card-body flex-grow-1">
                                <canvas id="realtimeChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card w-100 d-flex flex-column">
                    <div class="card-header">
                        <h4>Grafik Pemakaian Air</h4>
                    </div>

                    <div class="card-body flex-grow-1">
                        <canvas id="monthlyChart" height="500"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('monthlyChart')?.getContext('2d');
            const monthInput = document.getElementById('monthPicker');
            const deviceSelect = document.getElementById('deviceSelect');
            let chart;

            const rawData = @json($history ?? []);

            function updateChart(year, month) {
                const daysInMonth = new Date(year, month, 0).getDate();
                const labels = Array.from({
                    length: daysInMonth
                }, (_, i) => {
                    const day = (i + 1).toString().padStart(2, '0');
                    const date = new Date(`${year}-${month}-01`);
                    return `${day} ${date.toLocaleString('default', { month: 'short' })}`;
                });

                const fullDateMap = {};
                for (let i = 1; i <= daysInMonth; i++) {
                    const day = i.toString().padStart(2, '0');
                    const key = `${day}-${month}-${year}`;
                    fullDateMap[key] = 0;
                }

                for (const key in rawData) {
                    const [day, mon, yr] = key.split('-');
                    if (mon === month && yr === year) {
                        fullDateMap[key] = parseFloat(rawData[key]);
                    }
                }

                const values = Object.values(fullDateMap);

                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penggunaan Air (mL)',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: '#007bff',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#007bff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            },
                            y: {
                                min: 0,
                                title: {
                                    display: true,
                                    text: 'Jumlah (mL)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    }
                });
            }

            // Jalankan chart pertama kali
            const [initYear, initMonth] = monthInput.value.split('-');
            updateChart(initYear, initMonth);

            // Update saat bulan diganti
            monthInput.addEventListener('change', () => {
                const [year, month] = monthInput.value.split('-');
                updateChart(year, month);
            });
        });
    </script>


    {{-- realtime graph --}}
    <script>
        const flowData = @json($flowData ?? ['flowRate' => 0, 'totalML' => 0]);

        document.addEventListener('DOMContentLoaded', function() {
            const flowRateDisplay = document.getElementById('flowRate');
            const totalMLDisplay = document.getElementById('totalML');

            const ctx = document.getElementById('realtimeChart')?.getContext('2d');
            if (!ctx) {
                console.error('Elemen <canvas id="realtimeChart"> tidak ditemukan.');
                return;
            }

            Chart.defaults.font.family = 'Poppins';

            const chartData = {
                labels: [],
                datasets: [{
                    label: 'Flow Rate (L/min)',
                    data: [],
                    borderColor: 'rgba(0, 123, 255, 1)',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#007bff'
                }]
            };

            const flowChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    animation: false,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
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
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });

            function updateChart() {
                const now = new Date().toLocaleTimeString();

                const flowRate = parseFloat(flowData.flowRate || 0);
                const totalML = parseFloat(flowData.totalML || 0);

                // Update teks
                if (flowRateDisplay) flowRateDisplay.textContent = flowRate.toFixed(1);
                if (totalMLDisplay) totalMLDisplay.textContent = totalML.toFixed(0);

                // Update chart
                if (chartData.labels.length >= 10) {
                    chartData.labels.shift();
                    chartData.datasets[0].data.shift();
                }

                chartData.labels.push(now);
                chartData.datasets[0].data.push(flowRate);

                flowChart.update();
            }

            updateChart();

            setInterval(updateChart, 2000);
        });
    </script>
@endpush
