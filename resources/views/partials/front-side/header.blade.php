<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('index')}}">Shelfshop</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="{{route('cart')}}" class="btn btn-primary mr-2 user-cart">
            <i class="fa fa-shopping-cart"></i>
            Cart <span class="badge badge-light">{{$cart->total_quantity ?? 0}}</span>
        </a>
        <div class="navbar-collapse collapse" id="navbarCollapse">
            <div class="mr-auto"></div>
            <ul class="navbar-nav ">
                @auth
                    <li class="nav-item mr-md-2  mb-2 mb-md-0 mt-2 mt-md-0
                        {{ (request()->route()->getName() === 'dashboard') ? 'active' : '' }}">
                        <a href="{{route('dashboard')}}" class="btn btn-outline-success my-2 my-sm-0 nav-link">Dashboard</a>
                    </li>
                @else
                    <li class="nav-item mr-md-2  mb-2 mb-md-0 mt-2 mt-md-0
                        {{ (request()->route()->getName() === 'login') ? 'active' : '' }}">
                        <a href="{{route('login')}}" class="btn btn-outline-success my-2 my-sm-0 nav-link">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a href="{{route('register')}}" class="btn btn-outline-success my-2 my-sm-0 nav-link
                            {{ (request()->route()->getName() === 'register') ? 'active' : '' }}">Register</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </nav>
</header>
