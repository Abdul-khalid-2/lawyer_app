<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">LegalConnect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('find-lawyeres') }}">Find Lawyers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.howItWork') }}">How It Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.blog.index') }}">Blogs</a>
                </li>
            </ul>

            <div class="d-flex">
                @auth
                    @role('lawyer')
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
                    @endrole
                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button class="btn btn-outline-danger">Logout</button>
                    </form>
                @else
                    <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                @if (Route::has('register'))
                    <!-- <a href="{{ route('register') }}" class="btn btn-primary">Register</a> -->
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endif
                @endauth
            </div>
        </div>
    </div>
</nav>