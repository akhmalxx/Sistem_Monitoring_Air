<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg bg-primary">
    <a class="navbar-brand" href="#">My App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link " href="{{ url('/water-usage') }}">
                    Cek Meteran Air
                </a>
            </li>
        </ul>


        <span class="navbar-text">
            Navbar text with an inline element
        </span>
    </div>
</nav>
