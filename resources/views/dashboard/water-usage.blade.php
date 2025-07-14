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
                                            <label>Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h4>Grafik Pemakaian Air (Date)</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart" height="80"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Cek Pemakaian Realtime</h4>
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

    <script>
        $(document).ready(function() {
            // Tombol Date Picker -> mengisi input datepicker
            $('.daterange-btn').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: moment(), // Tidak bisa pilih lewat hari ini
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                // Set nilai input di bawahnya
                $('.datepicker').val(start.format('YYYY-MM-DD'));
            });

            // Inisialisasi ulang datepicker input untuk batasan hari ini juga (optional)
            $('.datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                maxDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });
    </script>
@endpush
