@extends('layouts.app')

@section('title', 'Documents - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-2">Documents archivés</h1>
            <p class="text-muted">{{ $documents->total() }} document(s) trouvé(s)</p>
        </div>
        <a href="{{ route('documents.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Déposer un document
        </a>
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

    <!-- Documents List -->
    @forelse($documents as $document)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="card-title mb-2">
                            <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none text-dark">
                                {{ $document->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-3">
                            {{ Str::limit($document->abstract, 250) }}
                        </p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <span><i class="bi bi-person me-1"></i>{{ $document->user->name }}</span>
                            <span><i class="bi bi-calendar me-1"></i>{{ $document->year }}</span>
                            <span><i class="bi bi-tag me-1"></i>{{ $document->documentType->name }}</span>
                            @if($document->department)
                                <span><i class="bi bi-building me-1"></i>{{ $document->department->name }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                <i class="bi bi-eye me-1"></i>{{ $document->getTotalViews() }} vues
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-download me-1"></i>{{ $document->getTotalDownloads() }} téléchargements
                            </small>
                        </div>
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-primary btn-sm">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-3">Aucun document trouvé.</p>
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $documents->links() }}
    </div>
</div>
@endsection
