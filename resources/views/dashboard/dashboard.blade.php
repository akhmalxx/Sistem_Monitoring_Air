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
                                <h2>Welcome</h2>
                                <p class="lead">Sistem Monitoring Air</p>
                                <div class="mt-4">
                                    <a href="/water-usage" class="btn btn-outline-white btn-lg btn-icon icon-left"><i
                                            class="fas fa-water"></i>
                                        CEK METERAN AIR</a>
                                </div>
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

            <div class="section text-center mt-5">
                <h2 class="text-primary font-weight-bold">Informasi Pelanggan dan Layanan</h2>
                <div class="mx-auto mt-3 mb-4 bg-primary" style="width: 80px; height: 3px;"></div>

                <div class="row justify-content-center">
                    <!-- Informasi Tagihan Air -->
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 p-4">
                            <div class="text-center text-primary mb-3">
                                <i class="fas fa-calculator" style="font-size: 40px;"></i>
                            </div>
                            <h5 class="text-primary font-weight-bold" style="font-size: 24px;">Informasi Tagihan Air</h5>
                            <p class="text-muted">Cek tagihan air anda untuk 1 bulan periode pemakaian terakhir</p>
                        </div>
                    </div>

                    <!-- Call Center -->
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 p-4">
                            <div class="text-center text-primary mb-3">
                                <i class="fas fa-headphones" style="font-size: 40px;"></i>
                            </div>
                            <h5 class="text-primary font-weight-bold" style="font-size: 24px;">Call Center</h5>
                            <p class="text-muted">Hubungi Call Center kami di<br>+62 878-0562-2615</p>
                        </div>
                    </div>

                    <!-- Hubungi Kami -->
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 p-4">
                            <div class="text-center text-primary mb-3">
                                <i class="fab fa-whatsapp fa-9x" style="font-size: 40px;"></i>
                            </div>
                            <h5 class="text-primary font-weight-bold" style="font-size: 24px;">Hubungi Kami</h5>
                            <p class="text-muted">Whatsapp pada nomor<br>+62 812-5620-1902</p>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>
@endpush
