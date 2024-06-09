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

    <style>
        body {
            margin: 0;
        }

        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s;
            z-index: 1000;
            overflow: hidden;
        }

        .sidebar-collapsed {
            width: 60px;
        }

        .sidebar-logo {
            padding: 20px;
            text-align: center;
        }

        .sidebar-logo img {
            max-width: 100%;
            height: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px 20px;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li a .menu-text {
            display: inline-block;
        }

        .sidebar-collapsed .menu-text {
            display: none;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .main {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            margin-left: 250px;
            padding-top: 60px;
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

        footer {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
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
                <footer>
                    &copy; {{ date('Y') }} Seu Projeto. Todos os direitos reservados.
                </footer>
            @show
        </div>
    </div>

    <script>
        // Script para manipular a colapsação da sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const header = document.querySelector('.header');
            const main = document.querySelector('.main');
            const collapseBtn = document.querySelector('.collapse-btn');
            let sidebarCollapsed = false;

            collapseBtn.addEventListener('click', function() {
                sidebarCollapsed = !sidebarCollapsed;
                sidebar.classList.toggle('sidebar-collapsed', sidebarCollapsed);
                header.classList.toggle('header-collapsed', sidebarCollapsed);
                main.classList.toggle('main-collapsed', sidebarCollapsed);
            });
        });
    </script>
</body>

</html>
