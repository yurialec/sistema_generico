<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if(isset(App\Models\Site\SiteLogo::first()->image))
            <img class="logo-link" src="{{'/storage/' . App\Models\Site\SiteLogo::first()->image}}">
            @else
            <i class="fa-solid fa-house"></i>
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @if(Route::getCurrentRoute()->uri !== "login")
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>