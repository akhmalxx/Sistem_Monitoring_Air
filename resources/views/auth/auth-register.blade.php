@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name">NAMA</label>
                        <input id="name" type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group col-12">
                        <label for="username">USERNAME</label>
                        <input id="username" type="text" class="form-control" name="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="password" class="d-block">PASSWORD</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control pwstrength"
                                data-indicator="pwindicator" name="password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                    data-target="#password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label for="password2" class="d-block">PASSWORD CONFIRMATION</label>
                        <div class="input-group">
                            <input id="password2" type="password" class="form-control" name="password_confirmation">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                    data-target="#password2">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small id="password-match-message" class="form-text"></small>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    @push('scripts')
        <script>
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const input = document.querySelector(this.dataset.target);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Live check password match
            const password = document.getElementById('password');
            const password2 = document.getElementById('password2');
            const message = document.getElementById('password-match-message');

            function checkPasswordMatch() {
                if (password2.value === '') {
                    message.textContent = '';
                    message.classList.remove('text-danger', 'text-success');
                } else if (password.value === password2.value) {
                    message.textContent = 'Password match.';
                    message.classList.remove('text-danger');
                    message.classList.add('text-success');
                } else {
                    message.textContent = 'Password doesn\'t match.';
                    message.classList.remove('text-success');
                    message.classList.add('text-danger');
                }
            }

            password.addEventListener('input', checkPasswordMatch);
            password2.addEventListener('input', checkPasswordMatch);
        </script>
    @endpush
@endpush
