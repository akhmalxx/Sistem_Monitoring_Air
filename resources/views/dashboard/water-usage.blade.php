@extends('layouts.app')

@section('title', 'Blank Page')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Monitoring Pemakaian dan Tagihan Air</h1>
            </div>

            <div class="section-body">
                <!-- Hero Section -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Cek Pemakaian dan Tagihan Air</h4>
                            </div>
                            <div class="card-body">
                                <p>Masukkan tanggal pemakaian air yang ingin dilihat</p>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4>Grafik Pemakaian Air (Date)</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart" height="50"></canvas>
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
