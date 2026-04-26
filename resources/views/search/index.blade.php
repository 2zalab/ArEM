@extends('layouts.app')

@section('title', 'Recherche - ArEM')

@section('styles')
<style>
    .search-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 48px 0 64px;
        position: relative;
        overflow: hidden;
    }

    .search-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -5%;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .search-bar-hero {
        background: white;
        border-radius: 50px;
        padding: 6px 6px 6px 24px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        max-width: 680px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-bar-hero input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1rem;
        background: transparent;
        color: #1a2a4a;
    }

    .search-bar-hero input::placeholder {
        color: #adb5bd;
    }

    .search-bar-hero button {
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        border: none;
        border-radius: 40px;
        padding: 10px 28px;
        font-weight: 600;
        color: white;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .search-bar-hero button:hover {
        opacity: 0.9;
        transform: scale(1.03);
    }

    /* Result card */
    .result-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.25s ease;
        margin-bottom: 1rem;
    }

    .result-card:hover {
        border-color: rgba(0,64,160,0.2);
        box-shadow: 0 6px 20px rgba(0,64,160,0.1);
        transform: translateY(-2px);
    }

    .result-card-inner {
        padding: 1.5rem;
    }

    .result-type-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(0,64,160,0.08), rgba(90,200,250,0.12));
        color: #0040A0;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 3px 10px;
        border-radius: 50px;
        border: 1px solid rgba(0,64,160,0.12);
        margin-bottom: 0.75rem;
    }

    .result-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a2a4a;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        text-decoration: none;
        display: block;
        transition: color 0.2s;
    }

    .result-title:hover {
        color: #0040A0;
    }

    .result-abstract {
        color: #6c757d;
        font-size: 0.92rem;
        line-height: 1.65;
        margin-bottom: 1rem;
    }

    .result-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        font-size: 0.85rem;
        color: #6c757d;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f2f5;
    }

    .result-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .result-meta i {
        color: #5AC8FA;
        font-size: 0.9rem;
    }

    .result-actions {
        display: flex;
        justify-content: flex-end;
        padding-top: 0.75rem;
    }

    /* Query highlight */
    .query-chip {
        display: inline-flex;
        align-items: center;
        background: rgba(0,64,160,0.08);
        color: #0040A0;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.95rem;
        border: 1px solid rgba(0,64,160,0.15);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(0,64,160,0.06), rgba(90,200,250,0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon i {
        font-size: 2rem;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection

@section('content')

<!-- Hero with search bar -->
<div class="search-hero">
    <div class="container-fluid px-5 position-relative" style="z-index:1;">
        <h1 class="fw-bold text-white mb-2" style="font-size:1.8rem;">
            @if(request('q'))
                Résultats pour <span style="color:#a8dff7;">"{{ request('q') }}"</span>
            @else
                Recherche dans les archives
            @endif
        </h1>
        @if(request('q'))
            <p class="mb-4" style="color:rgba(255,255,255,0.8);">
                {{ $documents->total() }} document(s) trouvé(s)
            </p>
        @else
            <p class="mb-4" style="color:rgba(255,255,255,0.8);">Parcourez {{ $documents->total() }} documents archivés</p>
        @endif

        <form action="{{ route('search') }}" method="GET">
            <div class="search-bar-hero">
                <i class="bi bi-search text-muted"></i>
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Rechercher par titre, auteur, mots-clés…"
                       autocomplete="off">
                <button type="submit">Rechercher</button>
            </div>
        </form>
    </div>
</div>
<div style="overflow:hidden;line-height:0;margin-top:-2px;background:linear-gradient(135deg,#0040A0,#5AC8FA);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,50 L0,50 Z" fill="#f8f9fa"/>
    </svg>
</div>

<div style="background:#f8f9fa;min-height:50vh;">
<div class="container-fluid px-5 py-5">
    <div class="row g-4">
        <!-- Filters sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color:#1a2a4a;">
                        <i class="bi bi-sliders me-2 text-primary"></i>Filtres
                    </h6>
                    <form action="{{ route('search') }}" method="GET">
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Type de document</label>
                            <select name="type" class="form-select form-select-sm">
                                <option value="">Tous les types</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Domaine</label>
                            <select name="department" class="form-select form-select-sm">
                                <option value="">Tous les domaines</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Langue</label>
                            <select name="language" class="form-select form-select-sm">
                                <option value="">Toutes les langues</option>
                                <option value="fr" {{ request('language') === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ request('language') === 'en' ? 'selected' : '' }}>Anglais</option>
                                <option value="de" {{ request('language') === 'de' ? 'selected' : '' }}>Allemand</option>
                            </select>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-muted">Année de</label>
                                <input type="number" name="year_from" class="form-control form-control-sm"
                                       placeholder="2010" value="{{ request('year_from') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-muted">À</label>
                                <input type="number" name="year_to" class="form-control form-control-sm"
                                       placeholder="{{ date('Y') }}" value="{{ request('year_to') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 mb-2">
                            <i class="bi bi-search me-1"></i>Appliquer
                        </button>
                        <a href="{{ route('search') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-x me-1"></i>Réinitialiser
                        </a>
                    </form>
                </div>
            </div>

            <div class="mt-3 text-center">
                <a href="{{ route('search.advanced') }}" class="text-decoration-none small" style="color:#0040A0;">
                    <i class="bi bi-sliders2 me-1"></i>Recherche avancée complète
                </a>
            </div>
        </div>

        <!-- Results -->
        <div class="col-lg-9">
            @if(request('q') || request('type') || request('department') || request('language'))
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="text-muted small">{{ $documents->total() }} résultat(s)</span>
                    @if(request('q'))
                        <span class="query-chip"><i class="bi bi-search me-1"></i>{{ request('q') }}</span>
                    @endif
                </div>
            @endif

            @forelse($documents as $document)
                <div class="result-card">
                    <div class="result-card-inner">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div class="flex-grow-1">
                                <span class="result-type-badge">{{ $document->documentType->name }}</span>
                                <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="result-title">
                                    {{ $document->title }}
                                </a>
                                <p class="result-abstract">{{ Str::limit($document->abstract, 260) }}</p>
                                <div class="result-meta">
                                    <span><i class="bi bi-person"></i>{{ $document->user->name }}</span>
                                    <span><i class="bi bi-calendar3"></i>{{ $document->year }}</span>
                                    @if($document->department)
                                        <span><i class="bi bi-building"></i>{{ $document->department->name }}</span>
                                    @endif
                                    <span><i class="bi bi-translate"></i>{{ strtoupper($document->language) }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('documents.show', $document->arem_doc_id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color:#1a2a4a;">Aucun résultat trouvé</h5>
                    <p class="text-muted mb-4">
                        @if(request('q'))
                            Aucun document ne correspond à <strong>"{{ request('q') }}"</strong>.<br>
                            Essayez avec d'autres mots-clés ou ajustez les filtres.
                        @else
                            Modifiez vos critères de recherche.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('search') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x me-1"></i>Effacer les filtres
                        </a>
                        <a href="{{ route('search.advanced') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-sliders me-1"></i>Recherche avancée
                        </a>
                    </div>
                </div>
            @endforelse

            @if($documents->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</div>

@endsection
