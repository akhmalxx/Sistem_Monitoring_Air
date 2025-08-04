<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg bg-primary">
    <img src="{{ asset('img/Logord.png') }}" alt="logo" width="55" class="bg-light rounded-circle p-1">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-home"> </i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                @if (auth()->user()->device)
                    <a class="nav-link " href="{{ url('/water-usage') }}">
                        <i class="fas fa-money-check"> </i> Cek Meteran Air
                    </a>
                @else
                    {{-- Jika user tidak punya device, tombol jalankan aksi swal-5 --}}
                    <a href="#" class="nav-link" id="swal-52">
                        <i class="fas fa-water"> </i> Cek Meteran Air
                    </a>
                @endif
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">
                        {{ Auth::user()->name }}
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    {{-- <div class="dropdown-divider"></div> --}}
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
