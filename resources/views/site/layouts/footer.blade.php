<footer class="section-padding bg-dark text-white">
    <div class="container">
        <div class="row">
            {{-- Redes sociais --}}
            <div class="col-lg-4 mb-4">
                @if(!empty($socialmedias) && count($socialmedias) > 0)
                    <h6 class="mb-3 text-uppercase fw-bold">Redes Sociais</h6>
                    <nav class="social-links d-flex gap-3" aria-label="Redes sociais">
                        @foreach($socialmedias as $social)
                            @php
                                $url = $social->url ?? '#';
                                $name = $social->name ?? 'Social';
                                $icon = $social->icon ?? 'bi bi-globe';
                            @endphp
                            @if(!empty($social->url))
                                <a href="{{ $url }}" class="text-white" target="_blank" rel="noopener noreferrer"
                                    title="{{ $name }}">
                                    <i class="{{ $icon }} fs-5"></i>
                                    <span class="visually-hidden">{{ $name }}</span>
                                </a>
                            @endif
                        @endforeach
                    </nav>
                @endif
            </div>

            {{-- Links rápidos --}}
            <div class="col-lg-2 mb-4">
                <h6 class="mb-3 text-uppercase fw-bold">Links Rápidos</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="#home" class="text-white-50">Início</a></li>
                    <li><a href="#carousel" class="text-white-50">Galeria</a></li>
                    <li><a href="#contact" class="text-white-50">Contato</a></li>
                    <li><a href="{{ route('login') }}" class="text-white-50">Área Restrita</a></li>
                </ul>
            </div>

            {{-- Contato --}}
            <div class="col-lg-4 mb-4">
                <h6 class="mb-3 text-uppercase fw-bold">Contato</h6>
                <ul class="list-unstyled mb-0">
                    @if(!empty($contact?->phone))
                        <li class="text-white-50 mb-1">
                            <i class="fas fa-phone-alt me-2"></i>
                            <a class="text-white-50 text-decoration-none"
                                href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}">
                                {{ $contact->phone }}
                            </a>
                        </li>
                    @endif

                    @if(!empty($contact?->email))
                        <li class="text-white-50 mb-1">
                            <i class="fas fa-envelope me-2"></i>
                            <a class="text-white-50 text-decoration-none" href="mailto:{{ $contact->email }}">
                                {{ $contact->email }}
                            </a>
                        </li>
                    @endif

                    @if(!empty($contact?->city))
                        <li class="text-white-50 mb-1">
                            <i class="fas fa-city me-2"></i>{{ $contact->city }}
                        </li>
                    @endif

                    @if(!empty($contact?->state))
                        <li class="text-white-50 mb-1">
                            <i class="fas fa-map me-2"></i>{{ $contact->state }}
                        </li>
                    @endif

                    @php
                        $hasAddress = !empty($contact?->address) || !empty($contact?->zipcode);
                        $mapsQuery = trim(($contact->address ?? '') . ' ' . ($contact->city ?? '') . ' ' . ($contact->state ?? '') . ' ' . ($contact->zipcode ?? ''));
                    @endphp

                    @if($hasAddress)
                        <li class="text-white-50 mb-1">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            @if(!empty($mapsQuery))
                                <a class="text-white-50 text-decoration-none"
                                    href="https://www.google.com/maps/search/{{ urlencode($mapsQuery) }}" target="_blank"
                                    rel="noopener noreferrer">
                                    {{ $contact->address ?? '' }}
                                    {{ !empty($contact?->address) && !empty($contact?->zipcode) ? ' - ' : '' }}
                                    {{ $contact->zipcode ?? '' }}
                                </a>
                            @else
                                {{ $contact->address ?? '' }}
                                {{ !empty($contact?->address) && !empty($contact?->zipcode) ? ' - ' : '' }}
                                {{ $contact->zipcode ?? '' }}
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-white-50">
                    &copy; {{ now()->year }} {{ $config->company_name ?? 'Sua Empresa' }}. Todos os direitos reservados.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                @if(!empty($config?->privacy_url))
                    <a href="{{ $config->privacy_url }}" class="text-white-50 me-3" target="_blank"
                        rel="noopener noreferrer">Política de Privacidade</a>
                @else
                    <a href="#" class="text-white-50 me-3">Política de Privacidade</a>
                @endif

                @if(!empty($config?->terms_url))
                    <a href="{{ $config->terms_url }}" class="text-white-50" target="_blank"
                        rel="noopener noreferrer">Termos de Uso</a>
                @else
                    <a href="#" class="text-white-50">Termos de Uso</a>
                @endif
            </div>
        </div>
    </div>
</footer>