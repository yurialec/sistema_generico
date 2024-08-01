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
            <div class="d-flex justify-content-center my-5">
                <div id="carouselExampleIndicators" class="carousel slide" style="max-width: 450px;">
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

            <div class="container my-5">
                <h3>BLOG</h3>
            </div>

            <div class="container my-5">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="mb-3">Assine</h2>
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-1">Assine nossa newsletter e mantenha-se atualizado</p>
                        <p>Não se preocupe, não enviaremos muito conteúdo.</p>
                        <form>
                            <div class="form-group">
                                <input type="email" class="form-control" id="fieldEmail" placeholder="Insira o seu endereço de email" required>
                                <div class="invalid-feedback">Insira o seu endereço de email, por favor</div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Inscrever-se</button>
                            <div class="form-group mt-2">
                                <label>
                                    <input type="checkbox" id="fieldSubscribe" value="true">
                                    Ao marcar esta caixa e enviar suas informações, você está nos dando permissão de lhe enviar e-mails. Você pode cancelar a qualquer momento.
                                </label>
                            </div>
                        </form>
                        <div class="mt-3" id="successMessage" style="display: none;">
                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                <h3>Inscrito!</h3>
                                Obrigado por se inscrever em nossa newsletter.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>

</html>