@extends('layouts.app')

@section('title', 'Recherche avancée - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="fw-bold mb-2">Recherche Avancée</h1>
            <p class="text-muted mb-4">Affinez votre recherche avec des critères spécifiques</p>

            <!-- Info Box -->
            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-lightbulb fs-4 me-3"></i>
                <div>
                    <strong>Astuce :</strong> Combinez plusieurs critères pour affiner vos résultats de recherche.
                    Laissez un champ vide pour ne pas filtrer sur ce critère.
                </div>
            </div>

            <!-- Search Form Card -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('search') }}" method="GET">
                        <!-- Recherche textuelle -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Recherche Textuelle</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="q" class="form-label">
                                        <i class="bi bi-search me-2"></i>Mots-clés
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="q"
                                           name="q"
                                           placeholder="Rechercher dans le titre, résumé, mots-clés..."
                                           value="{{ request('q') }}">
                                    <small class="form-text text-muted">Séparez les mots par des espaces pour chercher tous les termes</small>
                                </div>

                                <div class="col-md-12">
                                    <label for="author" class="form-label">
                                        <i class="bi bi-person me-2"></i>Auteur
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="author"
                                           name="author"
                                           placeholder="Nom et prénom de l'auteur"
                                           value="{{ request('author') }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Critères de filtrage -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Critères de Filtrage</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="type" class="form-label">
                                        <i class="bi bi-file-earmark-text me-2"></i>Type de document
                                    </label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="">Tous les types</option>
                                        @foreach($documentTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">
                                        <i class="bi bi-building me-2"></i>Département
                                    </label>
                                    <select name="department" id="department" class="form-select">
                                        <option value="">Tous les départements</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="language" class="form-label">
                                        <i class="bi bi-globe me-2"></i>Langue
                                    </label>
                                    <select name="language" id="language" class="form-select">
                                        <option value="">Toutes les langues</option>
                                        <option value="fr" {{ request('language') == 'fr' ? 'selected' : '' }}>Français</option>
                                        <option value="en" {{ request('language') == 'en' ? 'selected' : '' }}>Anglais</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Période temporelle -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Période</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="year_from" class="form-label">
                                        <i class="bi bi-calendar-check me-2"></i>Année de début
                                    </label>
                                    <input type="number"
                                           class="form-control"
                                           id="year_from"
                                           name="year_from"
                                           placeholder="Ex: 2020"
                                           value="{{ request('year_from') }}"
                                           min="1990"
                                           max="{{ date('Y') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="year_to" class="form-label">
                                        <i class="bi bi-calendar-x me-2"></i>Année de fin
                                    </label>
                                    <input type="number"
                                           class="form-control"
                                           id="year_to"
                                           name="year_to"
                                           placeholder="Ex: {{ date('Y') }}"
                                           value="{{ request('year_to') }}"
                                           min="1990"
                                           max="{{ date('Y') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Lancer la recherche
                            </button>
                            <a href="{{ route('search.advanced') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-lightbulb-fill text-warning fs-1 mb-3"></i>
                            <h6 class="fw-bold">Recherche intelligente</h6>
                            <p class="text-muted small mb-0">Les résultats sont triés par pertinence pour vous donner les meilleurs résultats en premier</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-filter-circle-fill text-info fs-1 mb-3"></i>
                            <h6 class="fw-bold">Filtres multiples</h6>
                            <p class="text-muted small mb-0">Combinez autant de critères que vous le souhaitez pour affiner votre recherche</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up-arrow text-primary fs-1 mb-3"></i>
                            <h6 class="fw-bold">Résultats précis</h6>
                            <p class="text-muted small mb-0">Notre algorithme vous garantit des résultats pertinents et actualisés</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
