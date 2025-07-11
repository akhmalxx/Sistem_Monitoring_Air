@extends('layouts.app')

@section('title', 'Update Data User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Update User</h1>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('user-management.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>NAMA</label>
                                <input type="text" name="name" class="form-control" required
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label>USERNAME</label>
                                <input type="text" name="username" class="form-control" required
                                    value="{{ $user->username }}">
                            </div>
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input type="text" name="email" class="form-control" required
                                    value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label>PASSWORD</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="abaikan jika tidak ingin mengubah!">
                            </div>
                            <div class="form-group">
                                <label>ROLE</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                                    <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                </select>
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
