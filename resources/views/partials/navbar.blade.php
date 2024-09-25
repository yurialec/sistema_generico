<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if (isset(App\Models\Site\SiteLogo::first()->image))
            <img style="display: flex;justify-content: center; align-items: center; width: auto; height: 60px"
                src="{{ '/storage/' . App\Models\Site\SiteLogo::first()->image }}">
            @else
            Home
            @endif
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <!-- @auth
                @if(session()->has('message'))
                <li>
                    <div id="welcomeAlert" style="width: 250px;" class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <script>
                        setTimeout(function() {
                            var alertElement = document.getElementById('welcomeAlert');
                            if (alertElement) {
                                var alert = new bootstrap.Alert(alertElement);
                                alert.close();
                            }
                        }, 5000);
                    </script>
                </li>
                @endif

                <li class="dropdown">
                    <i class="bi bi-person-circle h2" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="cart-container">
                                    <i style="font-size: large;" class="bi bi-cart4"></i>
                                    <span class="cart-count">10</span>
                                </div>
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">Minha conta</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sair</a></li>
                    </ul>
                </li>
                @endauth -->
                <li><a href="{{ route('about') }}">Sobre</a></li>
                <li><a href="{{ route('contact') }}">Contato</a></li>
                <li><a href="{{ route('site.blog.index') }}">Blog</a></li>
                <!-- @guest
                <li><a href="{{ route('ecommerce.login') }}">Entrar na loja</a></li>
                @endguest -->
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
        const body = document.querySelector('body');

        mobileNavToggle.addEventListener('click', function() {
            body.classList.toggle('mobile-nav-active');
        });
    });
</script>