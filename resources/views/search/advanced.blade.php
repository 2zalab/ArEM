@extends('layouts.app')

@section('title', 'Recherche avancée - ArEM')

@section('styles')
<style>
    .search-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 60px 0;
        margin-bottom: 40px;
        border-radius: 0 0 30px 30px;
    }

    .search-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 64, 160, 0.1);
        transition: all 0.3s;
    }

    .search-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0, 64, 160, 0.15);
    }

    .form-label {
        color: #0040A0;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e3f2fd;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #5AC8FA;
        box-shadow: 0 0 0 0.2rem rgba(90, 200, 250, 0.15);
    }

    .search-section {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .search-section-title {
        color: #0040A0;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-section-title i {
        color: #5AC8FA;
        font-size: 1.4rem;
    }

    .btn-search {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 40px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 64, 160, 0.3);
        color: white;
    }

    .btn-reset {
        border: 2px solid #5AC8FA;
        color: #0040A0;
        border-radius: 12px;
        padding: 14px 40px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-reset:hover {
        background: #5AC8FA;
        color: white;
        border-color: #5AC8FA;
    }

    .info-box {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        border-left: 4px solid #5AC8FA;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="search-hero">
    <div class="container-fluid px-5">
        <div class="text-center text-white">
            <i class="bi bi-search display-3 mb-3"></i>
            <h1 class="display-4 fw-bold mb-3">Recherche Avancée</h1>
            <p class="lead">Affinez votre recherche avec des critères spécifiques</p>
        </div>
    </div>
</div>

<div class="container-fluid px-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Info Box -->
            <div class="info-box">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb text-warning fs-2 me-3"></i>
                    <div>
                        <strong>Astuce :</strong> Combinez plusieurs critères pour affiner vos résultats de recherche.
                        Laissez un champ vide pour ne pas filtrer sur ce critère.
                    </div>
                </div>
            </div>

            <!-- Search Form Card -->
            <div class="search-card">
                <div class="card-body p-5">
                    <form action="{{ route('search') }}" method="GET">
                        <!-- Recherche textuelle -->
                        <div class="search-section">
                            <div class="search-section-title">
                                <i class="bi bi-keyboard"></i>
                                Recherche Textuelle
                            </div>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="q" class="form-label">
                                        <i class="bi bi-search me-2"></i>Mots-clés
                                    </label>
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           id="q"
                                           name="q"
                                           placeholder="Rechercher dans le titre, résumé, mots-clés..."
                                           value="{{ request('q') }}">
                                    <small class="text-muted">Séparez les mots par des espaces pour chercher tous les termes</small>
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

                        <!-- Critères de filtrage -->
                        <div class="search-section">
                            <div class="search-section-title">
                                <i class="bi bi-funnel"></i>
                                Critères de Filtrage
                            </div>
                            <div class="row g-4">
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

                        <!-- Période temporelle -->
                        <div class="search-section">
                            <div class="search-section-title">
                                <i class="bi bi-calendar-range"></i>
                                Période
                            </div>
                            <div class="row g-4">
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
                        <div class="d-flex gap-3 justify-content-center mt-4">
                            <button type="submit" class="btn btn-search btn-lg">
                                <i class="bi bi-search me-2"></i>Lancer la recherche
                            </button>
                            <a href="{{ route('search.advanced') }}" class="btn btn-reset btn-lg">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="bi bi-lightbulb-fill text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold" style="color: #0040A0;">Recherche intelligente</h5>
                        <p class="text-muted small">Les résultats sont triés par pertinence pour vous donner les meilleurs résultats en premier</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="bi bi-filter-circle-fill text-info fs-1 mb-3"></i>
                        <h5 class="fw-bold" style="color: #0040A0;">Filtres multiples</h5>
                        <p class="text-muted small">Combinez autant de critères que vous le souhaitez pour affiner votre recherche</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <i class="bi bi-graph-up-arrow fs-1 mb-3" style="color: #5AC8FA;"></i>
                        <h5 class="fw-bold" style="color: #0040A0;">Résultats précis</h5>
                        <p class="text-muted small">Notre algorithme vous garantit des résultats pertinents et actualisés</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
