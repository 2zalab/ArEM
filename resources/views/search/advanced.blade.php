@extends('layouts.app')

@section('title', 'Recherche avancée - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">Recherche avancée</h1>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="mb-4">
                            <label for="q" class="form-label fw-bold">Mots-clés</label>
                            <input type="text" class="form-control form-control-lg" id="q" name="q" placeholder="Rechercher dans le titre, résumé..." value="{{ request('q') }}">
                        </div>

                        <div class="mb-4">
                            <label for="author" class="form-label fw-bold">Auteur</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Nom de l'auteur" value="{{ request('author') }}">
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">Type de document</label>
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
                                <label for="department" class="form-label fw-bold">Département</label>
                                <select name="department" id="department" class="form-select">
                                    <option value="">Tous les départements</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="year_from" class="form-label fw-bold">Année (de)</label>
                                <input type="number" class="form-control" id="year_from" name="year_from" placeholder="Ex: 2020" value="{{ request('year_from') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="year_to" class="form-label fw-bold">Année (à)</label>
                                <input type="number" class="form-control" id="year_to" name="year_to" placeholder="Ex: 2024" value="{{ request('year_to') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="language" class="form-label fw-bold">Langue</label>
                            <select name="language" id="language" class="form-select">
                                <option value="">Toutes les langues</option>
                                <option value="fr" {{ request('language') == 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ request('language') == 'en' ? 'selected' : '' }}>Anglais</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-search me-2"></i>Rechercher
                            </button>
                            <a href="{{ route('search.advanced') }}" class="btn btn-outline-secondary btn-lg">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
