@extends('site.layouts.app')
@section('content')

    <!-- Hero Section -->

    @if(isset($mainText))
        <section id="home" class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">{{$mainText->title}}</h1>
                        <p class="lead mb-4">
                            {{$mainText->text}}
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{asset('img/tela-widescreen.jpg')}}" alt="Hero Image" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>
    @else
        ''
    @endif

    <!-- About Section -->
    @if(isset($about))
        <section id="about" class="section-padding bg-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <img src="{{ 'storage/' . $about->image }}" alt="Sobre" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-6">
                        <h2 class="text-primary mb-4">{{ $about->title }}</h2>
                        <p class="mb-4">
                            {{ $about->description }}
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
    @else
        ''
    @endif

    <!-- Carousel Section -->
    @if(!empty($carousels) && count($carousels))
        <section id="carousel" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($carousels as $i => $carousel)
                                    <button style="background-color: #007BFF;"
                                        type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $i }}"
                                        @class(['active' => $i === 0]) @if($i === 0) aria-current="true" @endif
                                        aria-label="Slide {{ $i + 1 }}">
                                    </button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded">
                                @foreach ($carousels as $carousel)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <img src="{{ 'storage/' . $carousel->image }}" class="d-block w-100"
                                            alt="{{ $carousel->title ?? 'Slide ' . ($loop->index + 1) }}" loading="lazy"
                                            style="object-fit: cover; aspect-ratio: 16/9;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-primary rounded-circle" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-primary rounded-circle" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        ''
    @endif

    <!-- Contact Section -->
    <!-- <section id="contact" class="section-padding bg-white">
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
                                                </section> -->
@endsection