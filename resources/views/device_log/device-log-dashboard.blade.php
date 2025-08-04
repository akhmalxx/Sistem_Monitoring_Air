@extends('layouts.app')

@section('title', 'Blank Page')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Monitoring Pemakaian Air</h1>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="row d-flex align-items-stretch">
                    <!-- Card Kiri -->
                    <div class="col-md-6 mb-2 d-flex">
                        <div class="card card-primary w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Pilih Device dan Bulan untuk melihat pemakaian air</h4>
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
                    <div class="col-md-6 mb-2 d-flex">
                        <div class="card card-primary w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Data Pemakaian Air</h4>
                            </div>

                            <div class="card-body flex-grow-1">
                                @if ($device && $device->user)
                                    <p>Nama Pelanggan : {{ $device->user->username }}</p>
                                @else
                                    <p>Nama Pelanggan : -</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success w-100 d-flex flex-column">
                    <div class="card-header">
                        <h4>Grafik Pemakaian Air Realtime</h4>

                    </div>

                    <div class="card-body flex-grow-1">
                        <canvas id="realtimeChart" height="500"></canvas>
                    </div>
                </div>

                <div class="card card-info w-100 d-flex flex-column">
                    <div class="card-header">
                        <h4>Grafik Pemakaian Air <span id="selectedMonthLabel"></span></h4>
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

                const orderedKeys = Object.keys(fullDateMap).sort((a, b) => {
                    const [da, ma, ya] = a.split('-').map(Number);
                    const [db, mb, yb] = b.split('-').map(Number);
                    return new Date(ya, ma - 1, da) - new Date(yb, mb - 1, db);
                });
                const values = orderedKeys.map(k => fullDateMap[k]);


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
                const selectedMonthLabel = document.getElementById('selectedMonthLabel');
                if (selectedMonthLabel) {
                    const monthName = new Date(`${year}-${month}-01`).toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    });
                    selectedMonthLabel.textContent = monthName;
                }

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalMLDisplay = document.getElementById('totalML');
            const ctx = document.getElementById('realtimeChart')?.getContext('2d');
            const deviceSelect = document.getElementById('deviceSelect');

            if (!ctx) {
                console.error('Elemen <canvas id="realtimeChart"> tidak ditemukan.');
                return;
            }

            const chartData = {
                labels: [],
                datasets: [{
                    label: 'Total Air (mL)',
                    data: [],
                    borderColor: 'rgba(40, 167, 69, 1)', // green
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#28a745'
                }]
            };

            const totalChart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    animation: false,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                drawTicks: true,
                                display: true,
                                drawOnChartArea: true,
                                color: '#ddd'
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0
                            },
                            title: {
                                display: true,
                                text: 'Waktu'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            min: 0,
                            suggestedMax: 1000, // default s/d 1000, tetapi bisa naik otomatis
                            ticks: {
                                stepSize: 100 // biar 10 grid kalau 0-1000
                            },
                            grid: {
                                drawBorder: true,
                                color: '#ddd'
                            },
                            title: {
                                display: true,
                                text: 'mL'
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

            let currentDeviceId = deviceSelect?.value;
            let lastTotalML = null;

            function fetchAndUpdateTotalML() {
                if (!currentDeviceId) return;

                fetch(`/device/realtime-data/${currentDeviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        const totalML = parseFloat(data.totalML || 0);

                        // update tampilan angka
                        if (totalMLDisplay) totalMLDisplay.textContent = totalML.toFixed(0);

                        // hanya update grafik jika totalML berubah
                        if (totalML !== lastTotalML) {
                            const now = new Date().toLocaleTimeString();

                            if (chartData.labels.length >= 10) {
                                chartData.labels.shift();
                                chartData.datasets[0].data.shift();
                            }

                            chartData.labels.push(now);
                            chartData.datasets[0].data.push(totalML);
                            totalChart.update();

                            lastTotalML = totalML; // simpan nilai terakhir
                        }
                    })
                    .catch(error => {
                        console.error('Gagal fetch data:', error);
                    });
            }

            // Jalankan polling tiap 2 detik
            const intervalId = setInterval(fetchAndUpdateTotalML, 2000);
            fetchAndUpdateTotalML(); // pertama kali

            // Ganti device -> reload halaman
            if (deviceSelect) {
                deviceSelect.addEventListener('change', function() {
                    window.location.href = `?device_id=${this.value}`;
                });
            }
        });
    </script>
@endpush
