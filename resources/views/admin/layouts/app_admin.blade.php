<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/sass/app_admin.scss'])
</head>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

<body id="app" class="sb-nav-fixed">
    @include('admin.layouts.header')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('admin.layouts.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main class="p-0">
                <div class="container-fluid px-4 mt-4">
                    @if ($errors->has('message'))
                        <div class="alert alert-danger alert-dismissible fade show col-md-4 col-md-offset-4" role="alert"
                            align="center">
                            {{ $errors->first('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
            @include('admin.layouts.footer')
        </div>
    </div>
    @stack('scripts')
</body>

</html>