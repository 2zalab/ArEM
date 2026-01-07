<x-guest-layout>
    <h4 class="fw-bold mb-4">Créer un compte</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

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
                autocomplete="username"
            >
            <div class="form-text">Utilisez votre email institutionnel</div>
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
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input
                type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                id="password_confirmation"
                name="password_confirmation"
                required
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus me-2"></i>Créer mon compte
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-2">Vous avez déjà un compte ?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>
