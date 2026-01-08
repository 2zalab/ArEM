@extends('layouts.app')

@section('title', 'Modifier l\'utilisateur - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="fw-bold mb-0">Modifier l'utilisateur</h1>
                    <p class="text-muted mb-0">{{ $user->name }} - {{ $user->email }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Informations de l'utilisateur</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nom complet *</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Adresse e-mail *</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold">Rôle *</label>
                            <select
                                class="form-select @error('role') is-invalid @enderror"
                                id="role"
                                name="role"
                                required
                            >
                                <option value="reader" {{ old('role', $user->role) == 'reader' ? 'selected' : '' }}>
                                    Lecteur
                                </option>
                                <option value="depositor" {{ old('role', $user->role) == 'depositor' ? 'selected' : '' }}>
                                    Déposant
                                </option>
                                <option value="moderator" {{ old('role', $user->role) == 'moderator' ? 'selected' : '' }}>
                                    Modérateur
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Administrateur
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <ul class="mb-0 mt-2">
                                    <li><strong>Lecteur :</strong> Consultation des documents publics</li>
                                    <li><strong>Déposant :</strong> Déposer et gérer ses documents</li>
                                    <li><strong>Modérateur :</strong> Valider les documents déposés</li>
                                    <li><strong>Administrateur :</strong> Accès complet au système</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="department_id" class="form-label fw-bold">Département</label>
                            <select
                                class="form-select @error('department_id') is-invalid @enderror"
                                id="department_id"
                                name="department_id"
                            >
                                <option value="">-- Non spécifié --</option>
                                @foreach($departments as $dept)
                                    <option
                                        value="{{ $dept->id }}"
                                        {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}
                                    >
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Informations supplémentaires</h6>
                                    <ul class="mb-0">
                                        <li><strong>Date d'inscription :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</li>
                                        <li>
                                            <strong>Statut de vérification :</strong>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">Vérifié le {{ $user->email_verified_at->format('d/m/Y') }}</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Non vérifié</span>
                                            @endif
                                        </li>
                                        <li><strong>Documents déposés :</strong> {{ $user->documents()->count() }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
