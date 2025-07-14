@extends('layouts.user-app')

@section('title', 'Blank Page')

@push('style')
    <style>
        .card-body {
            font-size: 16px;
        }

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


@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Home</h1>
            </div>

            <div class="section-body">
                <!-- Hero Section -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="hero bg-primary text-white">
                            <div class="hero-inner">
                                <h2>Welcome, tot!</h2>
                                <p class="lead">Selamat Datang di Website Sistem Monitoring Air</p>
                                <div class="mt-4">
                                    <a href="/water-usage" class="btn btn-outline-white btn-lg btn-icon icon-left"><i
                                            class="fas fa-water"></i>
                                        CEK METERAN AIR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header text-primary">
                            <h3>Tentang</h3>
                        </div>
                        <div class="card-body">
                            <p>Sistem Monitoring Air berbasis IoT ini merupakan proyek penelitian skripsi yang dirancang
                                untuk memantau penggunaan air secara real-time menggunakan sensor dan teknologi Internet of
                                Things (IoT). Sistem ini memungkinkan pelanggan maupun admin untuk mengakses informasi
                                pemakaian air dan tagihan secara langsung melalui antarmuka berbasis web.</p>
                            <p>Tujuan utama dari pengembangan sistem ini adalah untuk meningkatkan efisiensi pemantauan
                                konsumsi air, mendorong kesadaran pengguna terhadap penggunaan air bersih, serta menyediakan
                                data yang akurat dan terintegrasi guna mendukung pengambilan keputusan bagi instansi
                                penyedia layanan air.</p>
                            <p>Sistem ini dibangun dengan memanfaatkan sensor aliran air (flow sensor) yang terhubung dengan
                                mikrokontroler, yang kemudian mengirimkan data secara otomatis ke server melalui koneksi
                                internet. Data yang dikirim akan ditampilkan dalam bentuk grafik harian atau bulanan untuk
                                memudahkan pengguna memahami tren konsumsi mereka.</p>
                        </div>
                    </div>
                </div>

                <div>
                    
                </div>

                <!-- Card Section -->
                {{-- <div class="row d-flex align-items-stretch">
                    <!-- Card 1 (Lebar 4/12) -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4>Data Realtime</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Flow Rate : 0 L/Min</strong></p>
                                <p><strong>Total Pemakaian : 0 L</strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 (Lebar 8/12) -->
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4>Grafik Pemakaian Air (Realtime)</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>



        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>
@endpush
