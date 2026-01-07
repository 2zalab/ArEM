<x-guest-layout>
    <div class="auth-form-header">
        <h2>Connexion</h2>
        <p>Connectez-vous pour accéder à votre espace</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Se souvenir de moi
            </label>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
            </button>
        </div>

        <div class="text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-2">Pas encore de compte ?</p>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                Créer un compte
            </a>
        </div>
    </form>
</x-guest-layout>
