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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style scoped>
        .main {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            margin-left: 250px;
            margin-top: 60px;
            transition: margin-left 0.3s;
        }

        .main-collapsed {
            margin-left: 60px;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div id="app" class="dashboard">
        @section('sidebar')
            @include('admin.theme.sidebar')
        @show
        <div class="main">
            @section('header')
                @include('admin.theme.header')
            @show
            <div class="content-wrapper">
                <main class="content">
                    @yield('content')
                </main>
            </div>
            @section('footer')
                @include('admin.theme.footer')
            @show
        </div>
    </div>
</body>

</html>
