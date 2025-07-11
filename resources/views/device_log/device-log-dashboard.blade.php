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
                                    <label>Choose One</label>
                                    <select class="custom-select">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Card Chart -->
                    <div class="col-md-8 mb-4 d-flex">
                        <div class="card w-100 d-flex flex-column">
                            <div class="card-header">
                                <h4>Grafik Pemakaian Air (Realtime)</h4>
                            </div>

                            <div class="card-body flex-grow-1">
                                <canvas id="myChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @push('scripts')
        <!-- JS Libraies -->

        <!-- Page Specific JS File -->
    @endpush
