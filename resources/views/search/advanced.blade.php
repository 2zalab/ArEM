@extends('layouts.app')

@section('title', 'Recherche avancée - ArEM')

@section('styles')
<style>
    .adv-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 44px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .adv-hero::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .adv-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        right: -3%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    /* Section headings inside the form */
    .form-section-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #0040A0;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1.1rem;
    }

    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, rgba(0,64,160,0.15), transparent);
    }

    .form-section-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(0,64,160,0.1), rgba(90,200,250,0.15));
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #0040A0;
        flex-shrink: 0;
    }

    /* Form controls */
    .adv-form .form-control,
    .adv-form .form-select {
        border-radius: 10px;
        border-color: #e0e4ec;
        font-size: 0.93rem;
        padding: 0.55rem 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .adv-form .form-control:focus,
    .adv-form .form-select:focus {
        border-color: #0040A0;
        box-shadow: 0 0 0 0.2rem rgba(0,64,160,0.1);
    }

    .adv-form .form-label {
        font-size: 0.87rem;
        font-weight: 600;
        color: #3a4a6a;
        margin-bottom: 0.4rem;
    }

    .adv-form input[type="text"]::placeholder,
    .adv-form input[type="number"]::placeholder {
        color: #adb5bd;
        font-weight: 400;
    }

    /* Main form card */
    .adv-form-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    /* Tip cards */
    .tip-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 1.4rem;
        text-align: center;
        transition: all 0.25s ease;
    }

    .tip-card:hover {
        border-color: rgba(0,64,160,0.2);
        box-shadow: 0 6px 20px rgba(0,64,160,0.08);
        transform: translateY(-2px);
    }

    .tip-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(0,64,160,0.07), rgba(90,200,250,0.12));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .tip-icon i {
        font-size: 1.4rem;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Hint box */
    .hint-box {
        background: linear-gradient(135deg, rgba(0,64,160,0.04), rgba(90,200,250,0.07));
        border: 1px solid rgba(0,64,160,0.12);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }

    .hint-box i {
        font-size: 1.1rem;
        color: #0040A0;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .hint-box p {
        margin: 0;
        font-size: 0.9rem;
        color: #3a4a6a;
        line-height: 1.55;
    }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="adv-hero">
    <div class="container-fluid px-5 position-relative" style="z-index:1;">
        <span class="badge text-white mb-2 px-3 py-2" style="background:rgba(255,255,255,0.18);font-size:0.8rem;border-radius:50px;letter-spacing:0.5px;">
            <i class="bi bi-sliders2 me-1"></i>Recherche avancée
        </span>
        <h1 class="fw-bold text-white mb-1" style="font-size:1.9rem;">Recherche avancée</h1>
        <p class="mb-0" style="color:rgba(255,255,255,0.8);">Combinez plusieurs critères pour des résultats précis</p>
    </div>
</div>
<div style="overflow:hidden;line-height:0;margin-top:-2px;background:linear-gradient(135deg,#0040A0,#5AC8FA);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,50 L0,50 Z" fill="#f8f9fa"/>
    </svg>
</div>

<div style="background:#f8f9fa;min-height:60vh;">
<div class="container-fluid px-5 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <!-- Hint -->
            <div class="hint-box">
                <i class="bi bi-lightbulb-fill"></i>
                <p><strong>Astuce :</strong> Combinez plusieurs critères pour affiner vos résultats.
                   Laissez un champ vide pour ne pas filtrer sur ce critère.</p>
            </div>

            <!-- Form card -->
            <div class="adv-form-card adv-form">
                <form action="{{ route('search') }}" method="GET">

                    <!-- Recherche textuelle -->
                    <div class="mb-4">
                        <div class="form-section-title">
                            <span class="form-section-icon"><i class="bi bi-search"></i></span>
                            Recherche textuelle
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="q" class="form-label">Mots-clés</label>
                                <input type="text"
                                       class="form-control"
                                       id="q"
                                       name="q"
                                       placeholder="Rechercher dans le titre, résumé, mots-clés…"
                                       value="{{ request('q') }}">
                                <small class="text-muted" style="font-size:0.8rem;">Séparez les mots par des espaces pour chercher tous les termes</small>
                            </div>
                            <div class="col-md-12">
                                <label for="author" class="form-label">Auteur</label>
                                <input type="text"
                                       class="form-control"
                                       id="author"
                                       name="author"
                                       placeholder="Nom et prénom de l'auteur"
                                       value="{{ request('author') }}">
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#f0f2f5;margin:1.5rem 0;">

                    <!-- Critères de filtrage -->
                    <div class="mb-4">
                        <div class="form-section-title">
                            <span class="form-section-icon"><i class="bi bi-funnel"></i></span>
                            Critères de filtrage
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="type" class="form-label">Type de document</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">Tous les types</option>
                                    @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="department" class="form-label">Domaine</label>
                                <select name="department" id="department" class="form-select">
                                    <option value="">Tous les domaines</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="language" class="form-label">Langue</label>
                                <select name="language" id="language" class="form-select">
                                    <option value="">Toutes les langues</option>
                                    <option value="fr" {{ request('language') === 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ request('language') === 'en' ? 'selected' : '' }}>Anglais</option>
                                    <option value="de" {{ request('language') === 'de' ? 'selected' : '' }}>Allemand</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#f0f2f5;margin:1.5rem 0;">

                    <!-- Période -->
                    <div class="mb-4">
                        <div class="form-section-title">
                            <span class="form-section-icon"><i class="bi bi-calendar3"></i></span>
                            Période de publication
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="year_from" class="form-label">Année de début</label>
                                <input type="number"
                                       class="form-control"
                                       id="year_from"
                                       name="year_from"
                                       placeholder="2000"
                                       value="{{ request('year_from') }}"
                                       min="1990"
                                       max="{{ date('Y') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end pb-1">
                                <span class="text-muted fw-semibold" style="font-size:0.9rem;">→</span>
                            </div>
                            <div class="col-md-3">
                                <label for="year_to" class="form-label">Année de fin</label>
                                <input type="number"
                                       class="form-control"
                                       id="year_to"
                                       name="year_to"
                                       placeholder="{{ date('Y') }}"
                                       value="{{ request('year_to') }}"
                                       min="1990"
                                       max="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 pt-1">
                        <button type="submit"
                                class="btn btn-primary px-5"
                                style="border-radius:50px;background:linear-gradient(135deg,#0040A0,#5AC8FA);border:none;font-weight:600;box-shadow:0 4px 14px rgba(0,64,160,0.25);">
                            <i class="bi bi-search me-2"></i>Lancer la recherche
                        </button>
                        <a href="{{ route('search.advanced') }}"
                           class="btn btn-outline-secondary px-4"
                           style="border-radius:50px;">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                        </a>
                        <a href="{{ route('search') }}"
                           class="btn btn-link text-muted ms-auto"
                           style="font-size:0.88rem;">
                            <i class="bi bi-arrow-left me-1"></i>Recherche simple
                        </a>
                    </div>

                </form>
            </div>

            <!-- Tips -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="tip-card">
                        <div class="tip-icon"><i class="bi bi-lightbulb"></i></div>
                        <h6 class="fw-bold mb-1" style="color:#1a2a4a;">Recherche intelligente</h6>
                        <p class="text-muted small mb-0">Les résultats sont triés par pertinence pour vous offrir les meilleures correspondances en premier.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tip-card">
                        <div class="tip-icon"><i class="bi bi-intersect"></i></div>
                        <h6 class="fw-bold mb-1" style="color:#1a2a4a;">Filtres combinables</h6>
                        <p class="text-muted small mb-0">Combinez autant de critères que vous le souhaitez pour affiner précisément votre recherche.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tip-card">
                        <div class="tip-icon"><i class="bi bi-graph-up"></i></div>
                        <h6 class="fw-bold mb-1" style="color:#1a2a4a;">Résultats actualisés</h6>
                        <p class="text-muted small mb-0">Notre index couvre tous les documents publiés et est mis à jour en temps réel.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection
