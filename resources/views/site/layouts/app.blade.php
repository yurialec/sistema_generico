<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Genérico')</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;600&family=Raleway:wght@300;400;700&display=swap"
        rel="stylesheet">
    @vite(['resources/sass/site.scss', 'resources/js/app.js'])
    @yield('styles')
</head>

<body>
    @include('site.layouts.navbar')
    <main class="py-4">
        @yield('content')
    </main>
    @include('site.layouts.footer')
    @yield('scripts')
</body>

</html>