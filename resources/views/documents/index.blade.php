@extends('layouts.app')

@section('title', 'Documents - ArEM')

@section('styles')
<style>
    .docs-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 44px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .docs-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        left: -60px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .docs-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        right: -3%;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    /* Filter panel */
    .filter-panel {
        background: white;
        border-radius: 14px;
        border: 1px solid #e9ecef;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-panel .form-select,
    .filter-panel .form-control {
        border-radius: 8px;
        border-color: #dee2e6;
        font-size: 0.9rem;
    }

    .filter-panel .form-select:focus,
    .filter-panel .form-control:focus {
        border-color: #0040A0;
        box-shadow: 0 0 0 0.2rem rgba(0,64,160,0.1);
    }

    /* View toggle */
    .view-toggle .btn {
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        border-color: #dee2e6;
        color: #6c757d;
    }

    .view-toggle .btn.active {
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(0,64,160,0.25);
    }

    /* List card */
    .doc-list-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1rem;
        transition: all 0.25s ease;
    }

    .doc-list-card:hover {
        border-color: rgba(0,64,160,0.2);
        box-shadow: 0 6px 20px rgba(0,64,160,0.1);
        transform: translateY(-2px);
    }

    .doc-list-card-inner {
        padding: 1.4rem 1.5rem;
    }

    .doc-type-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(0,64,160,0.08), rgba(90,200,250,0.12));
        color: #0040A0;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 3px 10px;
        border-radius: 50px;
        border: 1px solid rgba(0,64,160,0.12);
        margin-bottom: 0.6rem;
    }

    .doc-list-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a2a4a;
        text-decoration: none;
        display: block;
        margin-bottom: 0.4rem;
        line-height: 1.4;
        transition: color 0.2s;
    }

    .doc-list-title:hover {
        color: #0040A0;
    }

    .doc-abstract {
        color: #6c757d;
        font-size: 0.91rem;
        line-height: 1.65;
        margin-bottom: 0.9rem;
    }

    .doc-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        font-size: 0.84rem;
        color: #6c757d;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f2f5;
    }

    .doc-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .doc-meta i {
        color: #5AC8FA;
    }

    /* Grid view */
    .documents-grid {
        display: none;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.25rem;
    }

    .documents-grid.active {
        display: grid;
    }

    .doc-grid-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .doc-grid-card:hover {
        border-color: rgba(0,64,160,0.2);
        box-shadow: 0 8px 24px rgba(0,64,160,0.12);
        transform: translateY(-3px);
    }

    .doc-grid-top {
        background: linear-gradient(135deg, rgba(0,64,160,0.04), rgba(90,200,250,0.08));
        padding: 1.1rem;
        border-bottom: 1px solid #f0f2f5;
    }

    .doc-grid-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a2a4a;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        transition: color 0.2s;
    }

    .doc-grid-title:hover {
        color: #0040A0;
    }

    .doc-grid-body {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .doc-grid-abstract {
        color: #6c757d;
        font-size: 0.88rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
        margin-bottom: 0.75rem;
    }

    .doc-grid-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.82rem;
        color: #6c757d;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f2f5;
        margin-bottom: 0.75rem;
    }

    .doc-grid-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .doc-grid-meta i {
        color: #5AC8FA;
    }

    /* Stats */
    .doc-stats {
        display: flex;
        gap: 1rem;
        font-size: 0.82rem;
        color: #adb5bd;
    }

    .doc-stats span {
        display: flex;
        align-items: center;
        gap: 4px;
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

    /* List view */
    .list-view { display: block; }
    .list-view:not(.active) { display: none; }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="docs-hero">
    <div class="container-fluid px-5 position-relative" style="z-index:1;">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <span class="badge text-white mb-2 px-3 py-2" style="background:rgba(255,255,255,0.18);font-size:0.8rem;border-radius:50px;letter-spacing:0.5px;">
                    <i class="bi bi-archive me-1"></i>Archives
                </span>
                <h1 class="fw-bold text-white mb-1" style="font-size:1.9rem;">Documents archivés</h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.8);">{{ $documents->total() }} document(s) disponible(s)</p>
            </div>
            <a href="{{ route('documents.create') }}"
               class="btn fw-semibold px-4 py-2"
               style="background:white;color:#0040A0;border-radius:50px;box-shadow:0 4px 14px rgba(0,0,0,0.15);">
                <i class="bi bi-plus-circle me-2"></i>Déposer un document
            </a>
        </div>
    </div>
</div>
<div style="overflow:hidden;line-height:0;margin-top:-2px;background:linear-gradient(135deg,#0040A0,#5AC8FA);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,50 L0,50 Z" fill="#f8f9fa"/>
    </svg>
</div>

<div style="background:#f8f9fa;min-height:60vh;">
<div class="container-fluid px-5 py-4">

    <!-- Filter panel -->
    <div class="filter-panel">
        <form action="{{ route('documents.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-tag me-1"></i>Type de document
                    </label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">Tous les types</option>
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-building me-1"></i>Domaine
                    </label>
                    <select name="department" class="form-select form-select-sm">
                        <option value="">Tous les domaines</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-calendar3 me-1"></i>Année
                    </label>
                    <input type="number" name="year" class="form-control form-control-sm"
                           placeholder="{{ date('Y') }}" value="{{ request('year') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-funnel me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Réinitialiser
                    </a>
                    <div class="ms-auto view-toggle d-flex gap-1">
                        <button type="button" class="btn btn-sm active" id="listViewBtn" onclick="switchView('list')">
                            <i class="bi bi-list-ul"></i>
                        </button>
                        <button type="button" class="btn btn-sm" id="gridViewBtn" onclick="switchView('grid')">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Active filters summary -->
    @if(request('type') || request('department') || request('year'))
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="text-muted small">{{ $documents->total() }} résultat(s) filtrés</span>
            @if(request('type'))
                <span class="badge" style="background:rgba(0,64,160,0.1);color:#0040A0;border:1px solid rgba(0,64,160,0.15);font-size:0.8rem;">
                    Type sélectionné
                </span>
            @endif
            @if(request('year'))
                <span class="badge" style="background:rgba(0,64,160,0.1);color:#0040A0;border:1px solid rgba(0,64,160,0.15);font-size:0.8rem;">
                    {{ request('year') }}
                </span>
            @endif
        </div>
    @endif

    <!-- List View -->
    <div class="list-view active" id="listView">
        @forelse($documents as $document)
            <div class="doc-list-card">
                <div class="doc-list-card-inner">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <span class="doc-type-badge">{{ $document->documentType->name }}</span>
                            <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="doc-list-title">
                                {{ $document->title }}
                            </a>
                            <p class="doc-abstract">{{ Str::limit($document->abstract, 280) }}</p>
                            <div class="doc-meta">
                                <span><i class="bi bi-person"></i>{{ $document->user->name }}</span>
                                <span><i class="bi bi-calendar3"></i>{{ $document->year }}</span>
                                @if($document->department)
                                    <span><i class="bi bi-building"></i>{{ $document->department->name }}</span>
                                @endif
                                <span><i class="bi bi-eye"></i>{{ $document->getTotalViews() }} vues</span>
                                <span><i class="bi bi-download"></i>{{ $document->getTotalDownloads() }}</span>
                                <span class="ms-auto">
                                    <a href="{{ route('documents.show', $document->arem_doc_id) }}"
                                       class="btn btn-sm btn-outline-primary" style="border-radius:20px;">
                                        <i class="bi bi-arrow-right me-1"></i>Voir
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-archive"></i></div>
                <h5 class="fw-bold mb-2" style="color:#1a2a4a;">Aucun document trouvé</h5>
                <p class="text-muted mb-4">Ajustez vos filtres ou déposez le premier document.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Effacer les filtres
                    </a>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Déposer un document
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Grid View -->
    <div class="documents-grid" id="gridView">
        @forelse($documents as $document)
            <div class="doc-grid-card">
                <div class="doc-grid-top">
                    <span class="doc-type-badge">{{ $document->documentType->name }}</span>
                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="doc-grid-title d-block mt-1">
                        {{ $document->title }}
                    </a>
                </div>
                <div class="doc-grid-body">
                    <p class="doc-grid-abstract">{{ Str::limit($document->abstract, 160) }}</p>
                    <div class="doc-grid-meta">
                        <span><i class="bi bi-person"></i>{{ Str::limit($document->user->name, 22) }}</span>
                        <span><i class="bi bi-calendar3"></i>{{ $document->year }}</span>
                        @if($document->department)
                            <span><i class="bi bi-building"></i>{{ Str::limit($document->department->name, 18) }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="doc-stats">
                            <span><i class="bi bi-eye"></i>{{ $document->getTotalViews() }}</span>
                            <span><i class="bi bi-download"></i>{{ $document->getTotalDownloads() }}</span>
                        </div>
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}"
                           class="btn btn-sm btn-outline-primary" style="border-radius:20px;font-size:0.82rem;">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon"><i class="bi bi-archive"></i></div>
                <h5 class="fw-bold mb-2" style="color:#1a2a4a;">Aucun document trouvé</h5>
                <p class="text-muted mb-4">Ajustez vos filtres ou déposez le premier document.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Effacer les filtres
                    </a>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Déposer un document
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($documents->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $documents->links() }}
        </div>
    @endif

</div>
</div>

@endsection

@section('scripts')
<script>
function switchView(viewType) {
    const listView = document.getElementById('listView');
    const gridView = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listViewBtn');
    const gridViewBtn = document.getElementById('gridViewBtn');

    if (viewType === 'list') {
        listView.classList.add('active');
        gridView.classList.remove('active');
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        localStorage.setItem('documentsView', 'list');
    } else {
        listView.classList.remove('active');
        gridView.classList.add('active');
        listViewBtn.classList.remove('active');
        gridViewBtn.classList.add('active');
        localStorage.setItem('documentsView', 'grid');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('documentsView') === 'grid') {
        switchView('grid');
    }
});
</script>
@endsection
