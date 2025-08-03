@extends('layouts.user-app')

@section('title', 'Blank Page')

@push('style')
    <!-- CSS Libraries -->

    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <style>
        .main-wrapper {
            padding-left: 0 !important;
        }

        .main-content {
            padding: 80px 30px 0px 30px !important;
        }


        body.sidebar-gone .main-content {
            margin-left: 0 !important;
        }

        .navbar {
            left: 0 !important;
        }

        .section {
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Monitoring Pemakaian dan Tagihan Air</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Cek Pemakaian dan Tagihan Air</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse-1" class="btn btn-icon btn-info" href="#"><i
                                class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse-1">
                    <div class="card-body">
                        <div class="row d-flex align-items-stretch">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Masukkan tanggal pemakaian air yang ingin dilihat</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <form method="GET" class="mb-4" id="monthForm">
                                                <label for="month">Pilih Bulan:</label>
                                                <input type="month" name="month" id="month"
                                                    value="{{ now()->format('Y-m') }}"
                                                    class="form-control w-auto d-inline-block">
                                            </form>



                                        </div>
                                        <p> </p>
                                        <p><strong>Total Tagihan : Rp.</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Grafik Pemakaian Air <span id="bulanTerpilih"></span></h4>

                                    </div>
                                    <div class="card-body" style="height: 300px;">
                                        <canvas id="historyChart" height="80"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Cek Pemakaian Real-Time</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse-2" class="btn btn-icon btn-info" href="#"><i
                                class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse-2">
                    <div class="card-body">
                        <div class="row d-flex align-items-stretch">
                            <!-- Card 1 (Lebar 4/12) -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Data Real-Time</h4>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Flow Rate : 0 ml/Min</strong></p>
                                        <p><strong>Total Pemakaian : 0 ml</strong></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 (Lebar 8/12) -->
                            <div class="col-md-8 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Grafik Pemakaian Air (Real-Time)</h4>
                                    </div>
                                    <div class="card-body" style="height: 300px;">
                                        <canvas id="realtimeChart"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('historyChart').getContext('2d');
            const monthInput = document.getElementById('month');
            const totalTagihanEl = document.querySelector('#totalTagihan');

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

                let total = 0;

                for (const key in rawData) {
                    const [day, mon, yr] = key.split('-');
                    if (mon === month && yr === year) {
                        const numericValue = parseFloat(rawData[key]);
                        fullDateMap[key] = numericValue;
                        total += numericValue;
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

                // Update total tagihan jika elemen ada
                if (totalTagihanEl) {
                    totalTagihanEl.textContent = 'Rp. ' + formatRupiah(total);
                }
                // Update teks bulan di judul chart
                const bulanLabel = new Date(`${year}-${month}-01`).toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('bulanTerpilih').textContent = bulanLabel.charAt(0).toUpperCase() +
                    bulanLabel.slice(1);

            }

            function formatRupiah(angka) {
                return angka.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            }

            // Inisialisasi awal chart
            const [initYear, initMonth] = monthInput.value.split('-');
            updateChart(initYear, initMonth);

            // Update chart ketika bulan diubah
            monthInput.addEventListener('change', function() {
                const [year, month] = this.value.split('-');
                updateChart(year, month);
            });

        });
    </script>

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
                            suggestedMax: 1000,
                            ticks: {
                                stepSize: 100
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

            let lastTotalML = null;

            function fetchAndUpdateTotalML() {
                const isUser = !deviceSelect;
                const endpoint = isUser ?
                    '/device/realtime-data' :
                    `/device/realtime-data/${deviceSelect.value}`;

                fetch(endpoint)
                    .then(response => response.json())
                    .then(data => {
                        const totalML = parseFloat(data.totalML || 0);

                        if (totalMLDisplay) {
                            totalMLDisplay.textContent = totalML.toFixed(0);
                        }

                        if (totalML !== lastTotalML) {
                            const now = new Date().toLocaleTimeString();

                            if (chartData.labels.length >= 10) {
                                chartData.labels.shift();
                                chartData.datasets[0].data.shift();
                            }

                            chartData.labels.push(now);
                            chartData.datasets[0].data.push(totalML);
                            totalChart.update();

                            lastTotalML = totalML;
                        }
                    })
                    .catch(error => {
                        console.error('Gagal fetch data:', error);
                    });
            }

            // Inisialisasi polling
            fetchAndUpdateTotalML();
            setInterval(fetchAndUpdateTotalML, 2000);

            // Ganti device (hanya berlaku untuk admin yang punya dropdown)
            if (deviceSelect) {
                deviceSelect.addEventListener('change', function() {
                    window.location.href = `?device_id=${this.value}`;
                });
            }
        });
    </script>
@endpush
