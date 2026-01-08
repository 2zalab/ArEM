<x-guest-layout>
    <div class="auth-form-header">
        <h2>Nouveau mot de passe</h2>
        <p>Choisissez un nouveau mot de passe sécurisé</p>
    </div>

    <div class="alert alert-info d-flex align-items-start mb-4">
        <i class="bi bi-shield-lock fs-5 me-3 mt-1"></i>
        <div>
            <strong>Conseils pour un mot de passe sécurisé :</strong>
            <ul class="mb-0 mt-2 small">
                <li>Au moins 8 caractères</li>
                <li>Mélangez majuscules, minuscules, chiffres et symboles</li>
                <li>Évitez les mots communs ou informations personnelles</li>
            </ul>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-2"></i>Email
            </label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                readonly
            >
            <div class="form-text">L'email associé à votre compte</div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="bi bi-key me-2"></i>Nouveau mot de passe
            </label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Saisissez votre nouveau mot de passe"
                >
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                    <i class="bi bi-eye" id="password-icon"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="bi bi-check2-circle me-2"></i>Confirmer le nouveau mot de passe
            </label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirmez votre nouveau mot de passe"
                >
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                    <i class="bi bi-eye" id="password_confirmation-icon"></i>
                </button>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-shield-check me-2"></i>Réinitialiser le mot de passe
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

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</x-guest-layout>
