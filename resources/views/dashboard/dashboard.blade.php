@extends('layouts.user-app')

@section('title', 'Blank Page')

@push('style')
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
                </div>

                <!-- Card Section -->

                <div class="row d-flex align-items-stretch">
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
