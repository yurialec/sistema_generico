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
    @vite(['resources/sass/site.scss', 'resources/js/app.js'])
</head>

<body>
    @include('partials.navbar')

    <div class="main-content container">
        <div class="container">
            <!-- Main Section -->
            <div class="row">
                <div class="col-md-8">
                    @if(isset(App\Models\Site\MainText::first()->title))
                    <h1>{{App\Models\Site\MainText::first()->title}}</h1>
                    @endif
                    @if(isset(App\Models\Site\MainText::first()->text))
                    <p>{{App\Models\Site\MainText::first()->text}}</p>
                    @endif
                </div>
            </div>

            <!-- Carousel Section -->
            <div class="container carousel-container">
                <div class="d-flex justify-content-center my-5">
                    <div id="carouselExampleIndicators" class="carousel slide" style="max-width: 800px;">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        </div>
                        <div class="carousel-inner">

                            <div class="carousel-item active">
                                <img src="https://plus.unsplash.com/premium_photo-1669686966146-da8d2400de46?q=80&w=1528&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100 h-40 mb-4" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5 style="background-color: #003366; border-radius: 10px;">First slide label</h5>
                                    <p style="background-color: #003366; border-radius: 10px;">Some representative placeholder content for the second slide.</p>
                                    <a href="#" target="_blank" style="background-color: #003366; border-radius: 10px; ">LINK EXTERNO</a>
                                </div>
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
                <div class="row justify-content-center">

                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card blog-card mb-4">
                            <img class="card-img-top" alt="thumbnail-blog" src="https://i.pinimg.com/564x/22/2a/5b/222a5b172d9bb69c4c4780261fa2f494.jpg">
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
                            <img class="card-img-top" alt="thumbnail-blog" src="https://upload.wikimedia.org/wikipedia/commons/6/68/Szczenie_Jack_Russell_Terrier3.jpg">
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
                            <img class="card-img-top" alt="thumbnail-blog" src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Golde33443.jpg">
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

    <div class="kv-content" data-padding-top="0" style="margin-top: 0px;">
        <div class="kv-ee-container kv-ee-main">
            <div class="kv-ee-row">
                <div class="kv-ee-col-lg-4 kv-ee-col-sm-12">
                    <div class="kv-ee-contact-about">
                        <h4 class="kv-ee-header" data-type="text" tabindex="0">LOREM IPSUM<span data-prop="titleDescription" class="ck-editable-element" data-editable="basic" style="display:none;"></span></h4>
                        <p class="kv-ee-description" data-type="text" tabindex="0">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                    </div>
                    <div class="kv-ee-logo-group">
                        <h3 class="kv-ee-logo-title kv-ee-title--md kv-ee-header" data-type="text" tabindex="0">
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </h3>
                    </div>
                </div>

                <div class="kv-ee-footer-navigation kv-ee-col-lg-4 kv-ee-col-md-6">
                    <p class="kv-ee-header" data-type="text" tabindex="0">Páginas<span data-prop="titleNavigation" class="ck-editable-element" data-editable="basic" style="display:none;"></span></p>
                    <nav class="kv-ee-links kv-ee-body-text">
                        <ul>
                            <li class="kv-ee-nav-title"><a href="/" data-uri-path="/" target="_self" class="">Início</a></li>
                            <li class="kv-ee-nav-title"><a href="/sobre" data-uri-path="/sobre" target="_self" class="">Sobre</a></li>
                            <li class="kv-ee-nav-title"><a href="/contato" data-uri-path="/contato" target="_self" class="">Contato</a></li>
                            <li class="kv-ee-nav-title"><a href="/blog" data-uri-path="/blog" target="_self" class="kv-ee-active">Blog</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="kv-ee-footer-social kv-ee-col-lg-4 kv-ee-col-md-6">
                    <p class="kv-ee-header" data-type="text" tabindex="0">Siga-nos<span data-prop="titleSocial" class="ck-editable-element" data-editable="basic" style="display:none;"></span></p>
                    <ul class="kv-ee-links kv-ee-body-text" data-type="social">
                        <li><a href="https://www.facebook.com/groups/404361246637936/?ref=share" target="_blank" aria-label="Social link Facebook"> <i class="bi bi-facebook"></i> <span class="kv-ee-social-provider">Facebook</span></a></li>
                        <li><a href="https://www.instagram.com/apemigos/" target="_blank" aria-label="Social link Instagram"> <i class="bi bi-instagram"></i> <span class="kv-ee-social-provider">Instagram</span></a></li>
                        <li><a href="https://youtube.com/channel/UC7nM7FEhWhs9CYBJKJKVkcA" target="_blank" aria-label="Social link YouTube"> <i class="bi bi-youtube"></i> <span class="kv-ee-social-provider">YouTube</span></a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="kv-ee-row">
                <div class="kv-ee-col-sm-6 kv-ee-footer-address" data-type="address">
                    <p class="kv-ee-body--sm">Brasília - DF, BR</p>
                </div>
                <div>
                    <a href="mailto:contato@apemigos.org" data-type="email">email@email.com</a>
                </div>
            </div>
            <div class="kv-ee-row kv-ee-legal">
                <div class="kv-ee-col-12"><a href="/sitemap.xml" target="_blank">Mapa do site</a></div>
                <div class="kv-ee-col-12">
                    <div class="kv-ee-legal-placeholder"></div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>

</html>