@extends('layouts.app')

@section('title', 'Modifier le profil - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h1 class="fw-bold mb-4">Paramètres du profil</h1>

            @if(session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>Profil mis à jour avec succès.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>Mot de passe modifié avec succès.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Update Profile Information -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Informations du profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Photo de profil -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Photo de profil</label>
                            <div class="d-flex align-items-center gap-3">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                         alt="Photo de profil"
                                         class="rounded-circle"
                                         style="width: 100px; height: 100px; object-fit: cover;"
                                         id="profilePhotoPreview">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                         style="width: 100px; height: 100px; font-size: 2rem;"
                                         id="profilePhotoPlaceholder">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file"
                                           class="form-control @error('profile_photo') is-invalid @enderror"
                                           id="profile_photo"
                                           name="profile_photo"
                                           accept="image/*"
                                           onchange="previewProfilePhoto(this)">
                                    <small class="form-text text-muted">Format: JPG, PNG. Taille max: 2MB</small>
                                    @error('profile_photo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Nom complet *</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Adresse e-mail *</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Votre adresse e-mail n'est pas vérifiée.
                                <button type="submit" form="send-verification" class="btn btn-sm btn-link p-0">
                                    Cliquez ici pour renvoyer l'e-mail de vérification.
                                </button>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success">
                                    Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                                </div>
                            @endif
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Téléphone</label>
                                <input
                                    type="tel"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    placeholder="+237 6XX XX XX XX"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="institution" class="form-label fw-bold">Établissement d'attache</label>
                                <input
                                    type="text"
                                    class="form-control @error('institution') is-invalid @enderror"
                                    id="institution"
                                    name="institution"
                                    value="{{ old('institution', auth()->user()->institution) }}"
                                    placeholder="Ex: ENS Maroua"
                                >
                                @error('institution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="user_type" class="form-label fw-bold">Type d'utilisateur</label>
                                <select class="form-select @error('user_type') is-invalid @enderror"
                                        id="user_type"
                                        name="user_type">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="etudiant" {{ old('user_type', auth()->user()->user_type) == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                    <option value="chercheur" {{ old('user_type', auth()->user()->user_type) == 'chercheur' ? 'selected' : '' }}>Chercheur</option>
                                    <option value="enseignant" {{ old('user_type', auth()->user()->user_type) == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                    <option value="autre" {{ old('user_type', auth()->user()->user_type) == 'autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('user_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grade" class="form-label fw-bold">Grade/Statut</label>
                                <select class="form-select @error('grade') is-invalid @enderror"
                                        id="grade"
                                        name="grade">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="Etudiant Licence" {{ old('grade', auth()->user()->grade) == 'Etudiant Licence' ? 'selected' : '' }}>Étudiant Licence</option>
                                    <option value="Etudiant Master" {{ old('grade', auth()->user()->grade) == 'Etudiant Master' ? 'selected' : '' }}>Étudiant Master</option>
                                    <option value="Doctorant" {{ old('grade', auth()->user()->grade) == 'Doctorant' ? 'selected' : '' }}>Doctorant</option>
                                    <option value="Assistant" {{ old('grade', auth()->user()->grade) == 'Assistant' ? 'selected' : '' }}>Assistant</option>
                                    <option value="Maître de Conférences" {{ old('grade', auth()->user()->grade) == 'Maître de Conférences' ? 'selected' : '' }}>Maître de Conférences</option>
                                    <option value="Professeur" {{ old('grade', auth()->user()->grade) == 'Professeur' ? 'selected' : '' }}>Professeur</option>
                                    <option value="Prof Lycées et Collèges" {{ old('grade', auth()->user()->grade) == 'Prof Lycées et Collèges' ? 'selected' : '' }}>Prof Lycées et Collèges</option>
                                    <option value="Chercheur" {{ old('grade', auth()->user()->grade) == 'Chercheur' ? 'selected' : '' }}>Chercheur</option>
                                    <option value="Autre" {{ old('grade', auth()->user()->grade) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="education_level" class="form-label fw-bold">Niveau d'étude / Diplôme</label>
                            <input
                                type="text"
                                class="form-control @error('education_level') is-invalid @enderror"
                                id="education_level"
                                name="education_level"
                                value="{{ old('education_level', auth()->user()->education_level) }}"
                                placeholder="Ex: Master 2, Doctorat, DIPES II"
                            >
                            @error('education_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Biographie</label>
                            <textarea
                                class="form-control @error('bio') is-invalid @enderror"
                                id="bio"
                                name="bio"
                                rows="3"
                                placeholder="Présentez-vous brièvement..."
                            >{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="research_interests" class="form-label fw-bold">Intérêts de recherche</label>
                            <textarea
                                class="form-control @error('research_interests') is-invalid @enderror"
                                id="research_interests"
                                name="research_interests"
                                rows="2"
                                placeholder="Vos domaines de recherche et centres d'intérêt..."
                            >{{ old('research_interests', auth()->user()->research_interests) }}</textarea>
                            @error('research_interests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Modifier le mot de passe</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Mot de passe actuel *</label>
                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                name="current_password"
                                autocomplete="current-password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Nouveau mot de passe *</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Confirmer le mot de passe *</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                            >
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Supprimer le compte</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Une fois votre compte supprimé, toutes vos données et documents seront définitivement effacés.
                        Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.
                    </p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        <i class="bi bi-trash me-2"></i>Supprimer le compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p class="fw-bold">Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                    <p class="text-muted">
                        Cette action est irréversible. Tous vos documents et données seront définitivement supprimés.
                    </p>

                    <div class="mb-3">
                        <label for="password_delete" class="form-label fw-bold">
                            Veuillez entrer votre mot de passe pour confirmer *
                        </label>
                        <input
                            type="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            id="password_delete"
                            name="password"
                            placeholder="Mot de passe"
                            required
                        >
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert:not(.alert-warning)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Show delete modal if there are validation errors
    @if($errors->userDeletion->any())
        const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    @endif
});

// Preview profile photo
function previewProfilePhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            const placeholder = document.getElementById('profilePhotoPlaceholder');

            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                // Replace placeholder with image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Photo de profil';
                img.className = 'rounded-circle';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.id = 'profilePhotoPreview';
                placeholder.replaceWith(img);
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
