@php
    $logo = App\Models\Site\SiteLogo::first();
@endphp
<footer class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                @if ($logo)
                    <img width="100" src="{{ asset('/storage/' . $logo->image) }}">
                @else
                    Home
                @endif
                <p>
                    Descrição breve da sua empresa ou slogan.
                    Mantenha uma mensagem clara e objetiva sobre seus serviços.
                </p>
                <div class="social-links">
                    <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <h6 class="mb-3">Links Rápidos</h6>
                <ul class="list-unstyled">
                    <li><a href="#home" class="text-white-50">Início</a></li>
                    <li><a href="#about" class="text-white-50">Sobre</a></li>
                    <li><a href="#carousel" class="text-white-50">Galeria</a></li>
                    <li><a href="#contact" class="text-white-50">Contato</a></li>
                    <li><a href="{{ route('login') }}" class="text-white-50">Área Restrita</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h6 class="mb-3">Serviços</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50">Serviço 1</a></li>
                    <li><a href="#" class="text-white-50">Serviço 2</a></li>
                    <li><a href="#" class="text-white-50">Serviço 3</a></li>
                    <li><a href="#" class="text-white-50">Serviço 4</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h6 class="mb-3">Contato</h6>
                <ul class="list-unstyled">
                    <li class="text-white-50"><i class="fas fa-map-marker-alt me-2"></i>Rua Exemplo, 123</li>
                    <li class="text-white-50"><i class="fas fa-phone me-2"></i>(11) 99999-9999</li>
                    <li class="text-white-50"><i class="fas fa-envelope me-2"></i>contato@exemplo.com</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-white-50">&copy; 2023 Sua Empresa. Todos os direitos reservados.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white-50 me-3">Política de Privacidade</a>
                <a href="#" class="text-white-50">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>