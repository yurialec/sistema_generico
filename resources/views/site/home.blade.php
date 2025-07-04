@extends('site.layouts.app')
@section('content')

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Seu Texto Principal</h1>
                    <p class="lead mb-4">
                        Este é o texto principal do seu site. Aqui você pode descrever sua empresa,
                        serviços ou qualquer mensagem importante que deseja transmitir aos visitantes.
                    </p>
                    <a href="#about" class="btn btn-light btn-lg">Saiba Mais</a>
                </div>
                <div class="col-lg-6">
                    <img src="{{asset('img/tela-widescreen.jpg')}}" alt="Hero Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Carousel Section -->
    <section id="carousel" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="text-primary">Nossa Galeria</h2>
                    <p class="lead">Confira alguns dos nossos trabalhos e momentos especiais</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0"
                                class="active"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner rounded">
                            <div class="carousel-item active">
                                <img src="https://cdn-dynmedia-1.microsoft.com/is/image/microsoftcorp/RE2wSVH_RE4dchU:VP4-630x449?resMode=sharp2&op_usm=1.5,0.65,15,0&qlt=75"
                                    class="d-block w-100" alt="Slide 1">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Primeiro Slide</h5>
                                    <p>Descrição do primeiro slide do carousel.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://www.naceweb.org/images/default-source/2023/feature/work-modality-the-changing-nature-of-where-we-work-xlarge.jpg"
                                    class="d-block w-100" alt="Slide 2">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Segundo Slide</h5>
                                    <p>Descrição do segundo slide do carousel.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://i.pinimg.com/736x/ae/01/bd/ae01bd89d2d14acd68d92f5f74cef4a0.jpg"
                                    class="d-block w-100" alt="Slide 3">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Terceiro Slide</h5>
                                    <p>Descrição do terceiro slide do carousel.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{asset('img/people.jpg')}}" alt="Sobre nós" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2 class="text-primary mb-4">Sobre Nós</h2>
                    <p class="mb-4">
                        Aqui você pode contar a história da sua empresa, seus valores, missão e visão.
                        Este espaço é ideal para criar uma conexão com seus visitantes e transmitir
                        confiança e credibilidade.
                    </p>
                    <p class="mb-4">
                        Descreva seus diferenciais, experiência no mercado e o que torna sua empresa
                        única. Use este espaço para destacar seus pontos fortes e conquistar a
                        confiança dos seus clientes.
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">100+</h3>
                                <p>Clientes Satisfeitos</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h3 class="text-primary">5+</h3>
                                <p>Anos de Experiência</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="text-primary">Nosso Blog</h2>
                    <p class="lead">Fique por dentro das últimas novidades e dicas</p>
                </div>
            </div>
            <div class="row">
                @foreach ($siteblogs as $blog)
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="{{'storage/' . $blog->images[0]['image_path'] }}" class="card-img-top" alt="Post 1">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $blog->title }}</h5>
                                <p class="card-text"> {{ $blog->description }}</p>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</small>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('site.blog.post', $blog->id) }}" class="btn btn-primary">Ler Mais</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="text-primary">Entre em Contato</h2>
                    <p class="lead">Estamos aqui para ajudar você</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-form">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Assunto</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 text-center mb-4">
                    <div class="p-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                        <h5>Endereço</h5>
                        <p>Rua Exemplo, 123<br>Cidade - Estado<br>CEP: 12345-678</p>
                    </div>
                </div>
                <div class="col-lg-4 text-center mb-4">
                    <div class="p-4">
                        <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                        <h5>Telefone</h5>
                        <p>(11) 99999-9999<br>(11) 3333-3333</p>
                    </div>
                </div>
                <div class="col-lg-4 text-center mb-4">
                    <div class="p-4">
                        <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                        <h5>E-mail</h5>
                        <p>contato@exemplo.com<br>vendas@exemplo.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection