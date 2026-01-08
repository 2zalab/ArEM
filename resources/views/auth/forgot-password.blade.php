<x-guest-layout>
    <div class="auth-form-header">
        <h2>Mot de passe oublié</h2>
        <p>Réinitialisez votre mot de passe en toute sécurité</p>
    </div>

    <div class="alert alert-info d-flex align-items-start mb-4">
        <i class="bi bi-info-circle fs-5 me-3 mt-1"></i>
        <div>
            <strong>Comment ça marche ?</strong>
            <p class="mb-0 mt-1">Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle fs-5 me-3"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-2"></i>Adresse email
            </label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="votre@email.com"
            >
            <div class="form-text">Entrez l'email utilisé lors de votre inscription</div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-send me-2"></i>Envoyer le lien de réinitialisation
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-2">Vous vous souvenez de votre mot de passe ?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
