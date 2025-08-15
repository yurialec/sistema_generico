@extends('site.layouts.app')
@section('content')
<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-card mx-auto">
                    <!-- <div class="login-header">
                        <div class="login-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h3>Bem-vindo de volta!</h3>
                        <p class="mb-0 opacity-75">Faça login para acessar sua conta</p>
                    </div> -->
                    <div class="login-body">
                        <!-- <div class="welcome-text">
                            <p class="mb-0">Entre com suas credenciais para continuar</p>
                        </div> -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>{{ __('E-mail') }}
                                </label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email"
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    autofocus
                                    placeholder="Digite seu e-mail">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2 text-primary"></i>{{ __('Senha') }}
                                </label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password"
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Digite sua senha">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Lembrar-me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Entrar') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="divider">
                                    <span>ou</span>
                                </div>
                                
                                <div class="text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-2"></i>{{ __('Esqueceu sua senha?') }}
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <!-- Informações adicionais -->
                <!-- <div class="text-center mt-4">
                    <p class="text-muted">
                        <small>
                            <i class="fas fa-shield-alt me-1"></i>
                            Seus dados estão protegidos e seguros
                        </small>
                    </p>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Script para melhorar a experiência do usuário -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar efeito de foco nos inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Animação suave para o card de login
    const loginCard = document.querySelector('.login-card');
    loginCard.style.opacity = '0';
    loginCard.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
        loginCard.style.transition = 'all 0.6s ease';
        loginCard.style.opacity = '1';
        loginCard.style.transform = 'translateY(0)';
    }, 100);
});
</script>
@endsection