@extends('layouts.user-app')

@section('title', 'Pemakaian Air')

@push('style')
    <!-- CSS Libraries -->

    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
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

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Cek Pemakaian dan Tagihan Air</h4>
                    <div class="card-header-action">
                        {{-- <a data-collapse="#mycard-collapse-1" class="btn btn-icon btn-info" href="#"><i
                                class="fas fa-minus"></i></a> --}}
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse-1">
                    <div class="card-body">
                        <div class="row d-flex align-items-stretch">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Masukkan bulan pemakaian air yang ingin dilihat</h4>
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
                                        <h3>Total Tagihan : </h3>
                                        <h3 class="text-primary"><span id="totalTagihan">Rp. 0</span></h3>
                                    </div>


                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mt-3" id="showDetailTagihan">Lihat Detail
                                            Tagihan</button>
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

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Cek Pemakaian Real-Time</h4>
                    <div class="card-header-action">
                        {{-- <a data-collapse="#mycard-collapse-2" class="btn btn-icon btn-info" href="#"><i
                                class="fas fa-minus"></i></a> --}}
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
                                        <p id="flowRateDisplay"><strong>Flow Rate : 0 ml/Min</strong></p>
                                        <p id="totalPemakaianDisplay"><strong>Total Pemakaian : 0 ml</strong></p>
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

    <!-- Modal -->
    <div class="modal fade" id="modalDetailTagihan" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Detail Tagihan Bulanan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <!-- Konten akan diisi lewat JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
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
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const tarifPerMl = 20; // Rp 20 per mL
        const rawData = @json($history ?? []);
        let chart;

        function formatRupiah(angka) {
            return angka.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
        }

        function buildDetailTableHTML(data, year, month) {
            const daysInMonth = new Date(year, month, 0).getDate();
            const fullDateMap = {};
            for (let i = 1; i <= daysInMonth; i++) {
                const day = i.toString().padStart(2, '0');
                const key = `${day}-${month}-${year}`;
                fullDateMap[key] = 0;
            }

            let totalTagihan = 0;
            let rowsHTML = '';

            for (const key in data) {
                const [d, m, y] = key.split('-');
                const paddedMonth = m.padStart(2, '0');
                if (paddedMonth === month && y === year) {
                    const val = parseFloat(data[key]);
                    if (val > 0) {
                        const tagihan = val * tarifPerMl;
                        totalTagihan += tagihan;
                        rowsHTML += `
                    <tr>
                        <td>${key}</td>
                        <td>${val}</td>
                        <td>Rp. ${formatRupiah(tagihan)}</td>
                    </tr>`;
                    }
                }
            }

            return `
        <div class="table-responsive mt-2">
            <table class="table table-bordered" id="detailTagihanTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pemakaian (mL)</th>
                        <th>Tagihan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    ${rowsHTML}
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total Tagihan</th>
                        <th>Rp. ${formatRupiah(totalTagihan)}</th>
                    </tr>
                </tfoot>
            </table>
        </div>`;
        }

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
                const paddedMon = mon.padStart(2, '0');
                if (paddedMon === month && yr === year) {
                    const numericValue = parseFloat(rawData[key]);
                    fullDateMap[key] = numericValue;
                    total += numericValue;
                }
            }

            // Update chart
            const ctx = document.getElementById('historyChart')?.getContext('2d');
            if (ctx) {
                if (chart) chart.destroy();
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penggunaan Air (mL)',
                            data: Object.values(fullDateMap),
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

            // Update total tagihan utama
            const totalTagihanEl = document.querySelector('#totalTagihan');
            const totalBayar = total * tarifPerMl;
            if (totalTagihanEl) {
                totalTagihanEl.textContent = 'Rp. ' + formatRupiah(totalBayar);
            }

            // Update bulan terpilih
            const bulanLabel = new Date(`${year}-${month}-01`).toLocaleString('id-ID', {
                month: 'long',
                year: 'numeric'
            });
            const bulanTitle = document.getElementById('bulanTerpilih');
            if (bulanTitle) {
                bulanTitle.textContent = bulanLabel.charAt(0).toUpperCase() + bulanLabel.slice(1);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const [initYear, initMonth] = document.getElementById('month').value.split('-');
            updateChart(initYear, initMonth);

            document.getElementById('month').addEventListener('change', function() {
                const [year, month] = this.value.split('-');
                updateChart(year, month);
            });

            document.getElementById('showDetailTagihan').addEventListener('click', function() {
                const [year, month] = document.getElementById('month').value.split('-');
                const html = buildDetailTableHTML(rawData, year, month);

                document.getElementById('modalBodyContent').innerHTML = html;
                $('#modalDetailTagihan').modal('show');
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalMLDisplay = document.getElementById('totalML');
            const totalPemakaianDisplay = document.getElementById('totalPemakaianDisplay');
            const flowRateDisplay = document.getElementById('flowRateDisplay');
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
                    borderColor: 'rgba(40, 167, 69, 1)',
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
                                stepSize: 200,
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
                        const flowRate = parseFloat(data.flowRate || 0);

                        if (totalMLDisplay) {
                            totalMLDisplay.textContent = totalML.toFixed(0);
                        }

                        // Update card: Total Pemakaian dan Flow Rate
                        if (totalPemakaianDisplay) {
                            totalPemakaianDisplay.innerHTML =
                                `<strong>Total Pemakaian : ${totalML.toFixed(0)} ml</strong>`;
                        }

                        if (flowRateDisplay) {
                            flowRateDisplay.innerHTML =
                                `<strong>Flow Rate : ${flowRate.toFixed(0)} ml/Min</strong>`;
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
