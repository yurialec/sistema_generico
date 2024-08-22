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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/sass/site.scss'])
</head>

<body>
    @include('partials.navbar')

    <div class="main-content container">
        <div class="container">
            <!-- Main Section -->
            <div class="row">
                <div class="col-md-8">
                    @if (isset(App\Models\Site\MainText::first()->title))
                        <h1>{{ App\Models\Site\MainText::first()->title }}</h1>
                    @endif
                    @if (isset(App\Models\Site\MainText::first()->text))
                        <p>{{ App\Models\Site\MainText::first()->text }}</p>
                    @endif
                </div>
            </div>

            @if (isset($carousels) && $carousels->isNotEmpty())
                <!-- Carousel Section -->
                <div class="container carousel-container">
                    <div class="d-flex justify-content-center my-5">
                        <div id="carouselExampleIndicators" class="carousel slide" style="max-width: 800px;">
                            <div class="carousel-inner">
                                @foreach ($carousels as $index => $carousel)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $carousel->image) }}"
                                            class="d-block w-100 h-40 mb-4" alt="...">

                                        @if ($carousel->title || $carousel->description || $carousel->url_link || $carousel->name_link)
                                            <div class="carousel-caption d-md-block">
                                                <h5>{{ $carousel->title }}</h5>
                                                <p>{{ $carousel->description }}</p>
                                                <a href="{{ $carousel->url_link }}"
                                                    target="_blank">{{ $carousel->name_link }}</a>
                                            </div>
                                        @else
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif


            <div class="container blog-section text-center">
                <h2>Blog</h2>
                <div class="row justify-content-center">

                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card blog-card mb-4">
                            <img class="card-img-top" alt="thumbnail-blog"
                                src="https://i.pinimg.com/564x/22/2a/5b/222a5b172d9bb69c4c4780261fa2f494.jpg">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary">View</button>
                                    </div>
                                    <small class="text-muted">9 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card blog-card mb-4">
                            <img class="card-img-top" alt="thumbnail-blog"
                                src="https://upload.wikimedia.org/wikipedia/commons/6/68/Szczenie_Jack_Russell_Terrier3.jpg">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary">View</button>
                                    </div>
                                    <small class="text-muted">9 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card blog-card mb-4">
                            <img class="card-img-top" alt="thumbnail-blog"
                                src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary">View</button>
                                    </div>
                                    <small class="text-muted">9 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container newsletter text-center py-5">
                <h2 class="display-4 font-weight-bold mb-4">Assine</h2>
                <p class="lead mb-4">Assine nossa newsletter e mantenha-se atualizado. Não se preocupe, não enviaremos
                    muito conteúdo.</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Insira o seu endereço de email"
                            required>
                        <button type="submit" class="btn btn-primary">Inscrever-se</button>
                    </div>
                    {{-- <div class="form-check text-left">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                        <label class="form-check-label" for="defaultCheck1">
                            Aceito a <a href="#">política de privacidade</a> e concordo em receber informações.
                        </label>
                    </div> --}}
                </form>
            </div>

        </div>
    </div>

    <div class="site-information">
        <div class="container">
            <div class="row">
                <div class="col-sm text-start">
                    <p><strong>Páginas</strong></p>
                    <nav>
                        <ul>
                            <li><a href="/">Início</a></li>
                            <li><a href="{{ route('about') }}">Sobre</a></li>
                            <li><a href="/contato">Contato</a></li>
                            <li><a href="/blog">Blog</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-sm text-center">
                    <p><strong>Contato</strong></p>
                    <nav>
                        <ul>
                            <li>Telefone</li>
                            <li>Email</li>
                            <li>Cidade/UF</li>
                            <li>Enderço</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-sm text-end">
                    <p><strong>Siga-nos</strong></p>
                    <nav>
                        <ul>
                            <li><i class="bi bi-instagram"></i> Instagram</li>
                            <li><i class="bi bi-facebook"></i> Youtube</li>
                            <li><i class="bi bi-youtube"></i> Facebook</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>

</html>
