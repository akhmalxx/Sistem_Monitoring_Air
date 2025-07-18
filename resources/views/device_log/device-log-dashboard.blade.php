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
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="card w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Card Action Button</h4>
                            </div>

                            <div class="card-body flex-grow-1">
                                <div class="form-group">
                                    <label>Pilih Device</label>
                                    <select class="custom-select" id="deviceSelect">
                                        <option selected disabled>Pilih Device</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->user->username }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <input type="month" class="form-control">
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Chart -->
                    <div class="col-md-8 mb-4 d-flex">
                        {{-- grafik --}}
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const ctx = document.getElementById('monthlyChart')?.getContext('2d');
            if (!ctx) return;

            const targetMonth = '07'; // ← Bulan yang ingin difilter (misalnya Juli = '07')
            const targetYear = '2025'; // ← Tahun yang ingin difilter

            try {
                const response = await fetch('/api/riwayat-air');
                const rawData = await response.json();

                // Step 1: Siapkan semua tanggal 1 - 31
                const daysInMonth = 31; // ← Sesuaikan jika mau lebih dinamis
                const labels = Array.from({
                    length: daysInMonth
                }, (_, i) => {
                    const day = (i + 1).toString().padStart(2, '0');
                    return `${day} ${new Date(`${targetYear}-${targetMonth}-01`).toLocaleString('default', { month: 'short' })}`;
                });

                // Step 2: Buat dictionary default data: { '01-07-2025': 0, ... }
                const fullDateMap = {};
                for (let i = 1; i <= daysInMonth; i++) {
                    const day = i.toString().padStart(2, '0');
                    const key = `${day}-${targetMonth}-${targetYear}`;
                    fullDateMap[key] = 0;
                }

                // Step 3: Masukkan data dari Firebase ke dalam map jika cocok bulan dan tahun
                for (const key in rawData) {
                    const [day, month, year] = key.split('-');
                    if (month === targetMonth && year === targetYear) {
                        fullDateMap[key] = parseFloat(rawData[key]);
                    }
                }

                // Step 4: Ambil nilai-nilai sesuai urutan label
                const values = Object.values(fullDateMap);

                // Step 5: Tampilkan Chart
                new Chart(ctx, {
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
                                max: 4000,
                                ticks: {
                                    stepSize: 500
                                },
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
            } catch (error) {
                console.error('Gagal ambil data Firebase:', error);
            }
        });
    </script>
@endpush
