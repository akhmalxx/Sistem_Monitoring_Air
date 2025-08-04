@extends('layouts.app')

@section('title', 'Edit Device')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Device</h1>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <form action="{{ route('device-list.update', $device) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>NAMA</label>
                                <select class="form-control" name="user_id" id="user_id" required>
                                    <option value="">Pilih Nama Pengguna</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $device->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>API KEY</label>
                                <input type="text" name="apikey" class="form-control" value="{{ $device->apikey }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>FIREBASE URL</label>
                                <input type="text" name="firebase_url" class="form-control"
                                    value="{{ $device->firebase_url }}" required>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
