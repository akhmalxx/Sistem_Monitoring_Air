<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; Sistem Monitoring Air</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- END GA -->

    {{-- tambahan chartjs --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/page/modules-chartjs.js') }}"></script> --}}
    <!-- IziToast CSS -->


</head>


<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- custom --}}
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">


    <!-- IziToast JS -->
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        @if (session('success'))
            iziToast.success({
                title: 'Berhasil',
                message: "{{ session('success') }}",
                position: 'topRight'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Gagal',
                message: "{{ session('error') }}",
                position: 'topRight'
            });
        @endif

        @if (session('info'))
            iziToast.info({
                title: 'Info',
                message: "{{ session('info') }}",
                position: 'topRight'
            });
        @endif

        @if (session('warning'))
            iziToast.warning({
                title: 'Peringatan',
                message: "{{ session('warning') }}",
                position: 'topRight'
            });
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.btn-hapus').on('click', function(e) {
                e.preventDefault();

                const form = $(this).closest('form');

                swal({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: "Batal",
                            visible: true,
                        },
                        confirm: {
                            text: "Hapus",
                            visible: true,
                        }
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });

                // Tambahkan styling Bootstrap (DOM ready)
                setTimeout(() => {
                    const swalButtons = document.querySelectorAll('.swal-button');
                    if (swalButtons.length === 2) {
                        swalButtons[0].classList.add('btn', 'btn-secondary'); // cancel
                        swalButtons[1].classList.add('btn', 'btn-primary'); // confirm
                    }
                }, 100);

            });
        });
    </script>

    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                iziToast.error({
                    title: 'Validasi Gagal',
                    message: "{{ $error }}",
                    position: 'topRight'
                });
            @endforeach
        @endif
    </script>


</body>

</html>
