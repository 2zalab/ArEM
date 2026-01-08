@extends('layouts.app')

@section('title', 'Documents - ArEM')

@section('styles')
<style>
    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-toggle .btn {
        padding: 0.5rem 1rem;
    }

    .view-toggle .btn.active {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        border-color: transparent;
    }

    /* List View Styles */
    .document-list-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 1rem;
    }

    .document-list-card:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0, 64, 160, 0.15);
    }

    .document-list-header {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .document-list-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0040A0;
        margin: 0;
    }

    .document-list-title a {
        color: inherit;
        text-decoration: none;
    }

    .document-list-title a:hover {
        color: #5AC8FA;
    }

    .document-list-body {
        padding: 1.5rem;
    }

    .document-list-abstract {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .document-list-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .document-list-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .document-list-meta i {
        color: #0040A0;
    }

    .document-list-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .document-list-stats {
        display: flex;
        gap: 1.5rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .document-list-stats span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Grid View Styles */
    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .document-grid-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .document-grid-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 64, 160, 0.15);
    }

    .document-grid-header {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .document-grid-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0040A0;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .document-grid-title a {
        color: inherit;
        text-decoration: none;
    }

    .document-grid-title a:hover {
        color: #5AC8FA;
    }

    .document-grid-body {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .document-grid-abstract {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
    }

    .document-grid-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .document-grid-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .document-grid-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .document-grid-stats-left {
        display: flex;
        gap: 1rem;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .document-grid-footer {
        padding: 0 1rem 1rem 1rem;
    }

    /* Badge Styling */
    .badge-document-type {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* Hide/Show views */
    .list-view {
        display: block;
    }

    .grid-view {
        display: none;
    }

    .grid-view.active {
        display: grid;
    }

    .list-view.active {
        display: block;
    }

    .list-view:not(.active) {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-2">Documents archivés</h1>
            <p class="text-muted">{{ $documents->total() }} document(s) trouvé(s)</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <!-- View Toggle -->
            <div class="view-toggle">
                <button type="button" class="btn btn-outline-secondary active" id="listViewBtn" onclick="switchView('list')">
                    <i class="bi bi-list-ul"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="gridViewBtn" onclick="switchView('grid')">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
            </div>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Déposer un document
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('documents.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Type de document</label>
                    <select name="type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Département</label>
                    <select name="department" class="form-select">
                        <option value="">Tous les départements</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Année</label>
                    <input type="number" name="year" class="form-control" placeholder="Ex: 2024" value="{{ request('year') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-2"></i>Filtrer
                    </button>
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Documents List View -->
    <div class="list-view active" id="listView">
        @forelse($documents as $document)
            <div class="document-list-card">
                <div class="document-list-header">
                    <h5 class="document-list-title">
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}">
                            {{ $document->title }}
                        </a>
                    </h5>
                    <span class="badge-document-type">{{ $document->documentType->name }}</span>
                </div>
                <div class="document-list-body">
                    <p class="document-list-abstract">
                        {{ Str::limit($document->abstract, 300) }}
                    </p>
                    <div class="document-list-meta">
                        <span><i class="bi bi-person"></i>{{ $document->user->name }}</span>
                        <span><i class="bi bi-calendar"></i>{{ $document->year }}</span>
                        @if($document->department)
                            <span><i class="bi bi-building"></i>{{ $document->department->name }}</span>
                        @endif
                    </div>
                    <div class="document-list-footer">
                        <div class="document-list-stats">
                            <span><i class="bi bi-eye"></i>{{ $document->getTotalViews() }} vues</span>
                            <span><i class="bi bi-download"></i>{{ $document->getTotalDownloads() }} téléchargements</span>
                        </div>
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Voir détails
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3">Aucun document trouvé.</p>
            </div>
        @endforelse
    </div>

    <!-- Documents Grid View -->
    <div class="documents-grid grid-view" id="gridView">
        @forelse($documents as $document)
            <div class="document-grid-card">
                <div class="document-grid-header">
                    <div class="document-grid-title">
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}">
                            {{ $document->title }}
                        </a>
                    </div>
                    <span class="badge bg-primary">{{ $document->documentType->name }}</span>
                </div>
                <div class="document-grid-body">
                    <p class="document-grid-abstract">
                        {{ Str::limit($document->abstract, 150) }}
                    </p>
                    <div class="document-grid-meta">
                        <span><i class="bi bi-person"></i>{{ Str::limit($document->user->name, 20) }}</span>
                        <span><i class="bi bi-calendar"></i>{{ $document->year }}</span>
                        @if($document->department)
                            <span><i class="bi bi-building"></i>{{ Str::limit($document->department->name, 20) }}</span>
                        @endif
                    </div>
                    <div class="document-grid-stats">
                        <div class="document-grid-stats-left">
                            <span><i class="bi bi-eye me-1"></i>{{ $document->getTotalViews() }}</span>
                            <span><i class="bi bi-download me-1"></i>{{ $document->getTotalDownloads() }}</span>
                        </div>
                    </div>
                </div>
                <div class="document-grid-footer">
                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-eye me-1"></i>Voir détails
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-5" style="grid-column: 1 / -1;">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3">Aucun document trouvé.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
// View switching functionality
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

        // Save preference to localStorage
        localStorage.setItem('documentsView', 'list');
    } else if (viewType === 'grid') {
        listView.classList.remove('active');
        gridView.classList.add('active');
        listViewBtn.classList.remove('active');
        gridViewBtn.classList.add('active');

        // Save preference to localStorage
        localStorage.setItem('documentsView', 'grid');
    }
}

// Load saved view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('documentsView');
    if (savedView === 'grid') {
        switchView('grid');
    }
    // Default is list, so no need to do anything if savedView is null or 'list'
});
</script>
@endsection
