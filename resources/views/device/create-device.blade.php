@extends('layouts.app')

@section('title', 'Tambah Device')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Device</h1>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">

                    <form action="{{ route('device-list.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>NAMA</label>
                                <select class="form-control" name="user_id" id="user_id" required>
                                    <option value="">Pilih Nama Pengguna</option>
                                    @foreach ($users as $user)
                                        @if (!in_array($user->id, $usedUserIds))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label>API KEY</label>
                                <input type="text" name="apikey" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>FIREBASE URL</label>
                                <input type="text" name="firebase_url" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>FIREBASE SECRET</label>
                                <input type="text" name="firebase_secret" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
