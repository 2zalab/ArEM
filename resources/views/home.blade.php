@extends('layouts.app')

@section('title', 'ArEM - Plateforme d\'Archives ENS Maroua')

@section('styles')
<style>
    .hero-section {
        position: relative;
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        background-image:
            linear-gradient(135deg, rgba(0, 51, 102, 0.92) 0%, rgba(0, 153, 204, 0) 100%),
            url('/images/univ-maroua.jpg');
        background-size: cover;
        background-position: center;
        padding: 80px 0;
        margin-bottom: 60px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        backdrop-filter: blur(2px);
        z-index: 0;
    }

    .hero-section > .container-fluid {
        position: relative;
        z-index: 1;
    }

    .hero-logo {
        max-width: 120px;
        margin-bottom: 20px;
        filter: brightness(0) invert(1);
    }

    .search-box {
        background: white;
        border-radius: 50px;
        padding: 8px 8px 8px 24px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        max-width: 800px;
        margin: 0 auto;
    }

    .search-box input {
        border: none;
        outline: none;
        font-size: 1.1rem;
    }

    .search-box button {
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        border: none;
        border-radius: 40px;
        padding: 12px 32px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }

    .search-box button:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 184, 148, 0.4);
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-8px);
    }

    .stat-card i {
        font-size: 3rem;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0040A0;
        margin: 16px 0 8px;
    }

    .document-card {
        border-left: 4px solid #5AC8FA;
    }

    .document-card:hover {
        border-left-color: #0040A0;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container-fluid px-5">
        <div class="text-center text-white mb-5">
            <h1 class="display-4 fw-bold mb-3">Explorez, partagez et valorisez</h1>
            <p class="lead mb-4">la production scientifique et académique de notre institution</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET">
            <div class="search-box">
                <div class="row g-0 align-items-center">
                    <div class="col">
                        <input
                            type="text"
                            name="q"
                            class="form-control form-control-lg border-0"
                            placeholder="Rechercher par titre, auteur, mots-clés..."
                            value="{{ request('q') }}"
                        >
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-lg">
                            <i class="bi bi-search me-2"></i>Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('documents.create') }}" class="btn btn-light btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Déposer un document
            </a>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="container-fluid px-5 mb-5">
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <i class="bi bi-file-earmark-text"></i>
                <h3>{{ $statistics['total_documents'] }}</h3>
                <p class="text-muted mb-0">Documents archivés</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <i class="bi bi-people"></i>
                <h3>{{ $statistics['total_authors'] }}</h3>
                <p class="text-muted mb-0">Auteurs</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <i class="bi bi-building"></i>
                <h3>{{ $statistics['total_departments'] }}</h3>
                <p class="text-muted mb-0">Départements</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <i class="bi bi-download"></i>
                <h3>{{ $statistics['total_downloads'] }}</h3>
                <p class="text-muted mb-0">Téléchargements</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid px-5">
    <div class="row g-4">
        <!-- Recent Documents -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Documents récents</h3>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-primary btn-sm">
                    Voir tout <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

            @forelse($recentDocuments as $document)
                <div class="card document-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none text-dark">
                                {{ $document->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($document->abstract, 200) }}
                        </p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <span><i class="bi bi-person me-1"></i>{{ $document->user->name }}</span>
                            <span><i class="bi bi-calendar me-1"></i>{{ $document->year }}</span>
                            <span><i class="bi bi-tag me-1"></i>{{ $document->documentType->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Aucun document disponible pour le moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Access -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Accès rapide</h5>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('documents.create') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="bi bi-plus-circle text-primary me-2"></i>Déposer un document
                        </a>
                        <a href="{{ route('documents.browse', ['by' => 'type']) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="bi bi-folder text-primary me-2"></i>Par type de document
                        </a>
                        <a href="{{ route('documents.browse', ['by' => 'department']) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="bi bi-building text-primary me-2"></i>Par département
                        </a>
                        <a href="{{ route('documents.browse', ['by' => 'year']) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="bi bi-calendar text-primary me-2"></i>Par année
                        </a>
                    </div>
                </div>
            </div>

            <!-- Popular Documents -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Documents populaires</h5>
                    @forelse($popularDocuments as $document)
                        <div class="mb-3 pb-3 border-bottom">
                            <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none">
                                <h6 class="mb-1">{{ Str::limit($document->title, 60) }}</h6>
                            </a>
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>{{ $document->getTotalViews() }} vues
                            </small>
                        </div>
                    @empty
                        <p class="text-muted small">Aucune statistique disponible</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
