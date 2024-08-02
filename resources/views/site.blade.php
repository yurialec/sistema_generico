<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Genérico</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/site.scss', 'resources/js/app.js'])
</head>

<body>
    @include('partials.navbar')

    <div class="main-content container">
        <div class="container">
            <!-- Main Section -->
            <div class="row">
                <div class="col-md-8">
                    <h1>Título da Página</h1>
                    <p>Texto genérico alinhado à esquerda. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>

            <!-- Carousel Section -->
            <div class="container carousel-container">
                <div class="d-flex justify-content-center my-5">
                    <div id="carouselExampleIndicators" class="carousel slide" style="max-width: 350px;">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://plus.unsplash.com/premium_photo-1669686966146-da8d2400de46?q=80&w=1528&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.pexels.com/photos/5292267/pexels-photo-5292267.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="container blog-section text-center">
                <h2>Blog</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card blog-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h5 class="card-title">Blog Post 1</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <a href="#" class="btn btn-primary">View</a>
                                <a href="#" class="btn btn-secondary">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card blog-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h5 class="card-title">Blog Post 2</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <a href="#" class="btn btn-primary">View</a>
                                <a href="#" class="btn btn-secondary">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card blog-card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h5 class="card-title">Blog Post 3</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <a href="#" class="btn btn-primary">View</a>
                                <a href="#" class="btn btn-secondary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container my-5  bg-light">
                <h3>** SESSÃO TRANSPARÊSNCIA **</h3>
            </div>



            <div class="container newsletter text-center py-5">
                <h2 class="display-4 font-weight-bold mb-4">Assine</h2>
                <p class="lead mb-4">Assine nossa newsletter e mantenha-se atualizado. Não se preocupe, não enviaremos muito conteúdo.</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Insira o seu endereço de email" required>
                        <button type="submit" class="btn btn-primary">Inscrever-se</button>
                    </div>
                    <div class="form-check text-left">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                        <label class="form-check-label" for="defaultCheck1">
                            Aceito a <a href="#">política de privacidade</a> e concordo em receber informações.
                        </label>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>

</html>