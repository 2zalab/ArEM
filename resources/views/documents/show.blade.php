@extends('layouts.app')

@section('title', $document->title . ' - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Document Header -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary">{{ $document->documentType->name }}</span>
                        <span class="badge bg-secondary">{{ $document->status }}</span>
                    </div>

                    <h1 class="fw-bold mb-3">{{ $document->title }}</h1>

                    <div class="d-flex flex-wrap gap-3 text-muted mb-4">
                        <span><i class="bi bi-person me-2"></i>{{ $document->user->name }}</span>
                        <span><i class="bi bi-calendar me-2"></i>{{ $document->year }}</span>
                        @if($document->department)
                            <span><i class="bi bi-building me-2"></i>{{ $document->department->name }}</span>
                        @endif
                        <span><i class="bi bi-globe me-2"></i>{{ strtoupper($document->language) }}</span>
                    </div>

                    <div class="border-top pt-3 mb-3">
                        <h5 class="fw-bold mb-2">Résumé</h5>
                        <p class="text-muted">{{ $document->abstract }}</p>
                    </div>

                    @if($document->keywords && count($document->keywords) > 0)
                        <div class="border-top pt-3">
                            <h6 class="fw-bold mb-2">Mots-clés</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($document->keywords as $keyword)
                                    <span class="badge bg-light text-dark">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            @if($document->metadata->count() > 0)
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Métadonnées supplémentaires</h5>
                        <dl class="row mb-0">
                            @foreach($document->metadata as $meta)
                                <dt class="col-sm-4">{{ ucfirst(str_replace('_', ' ', $meta->meta_key)) }}</dt>
                                <dd class="col-sm-8">{{ $meta->meta_value }}</dd>
                            @endforeach
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Actions</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('documents.download', $document->arem_doc_id) }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Télécharger le PDF
                        </a>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#shareModal">
                            <i class="bi bi-share me-2"></i>Partager
                        </button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#citeModal">
                            <i class="bi bi-quote me-2"></i>Citer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Statistiques</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="bi bi-eye me-2"></i>Vues</span>
                        <strong>{{ $totalViews }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><i class="bi bi-download me-2"></i>Téléchargements</span>
                        <strong>{{ $totalDownloads }}</strong>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Informations</h5>
                    <dl class="mb-0">
                        <dt class="small text-muted">Identifiant ArEM</dt>
                        <dd class="mb-3"><code>{{ $document->arem_doc_id }}</code></dd>

                        <dt class="small text-muted">Date de publication</dt>
                        <dd class="mb-3">{{ $document->published_at ? $document->published_at->format('d/m/Y') : 'Non publié' }}</dd>

                        <dt class="small text-muted">Droits d'accès</dt>
                        <dd class="mb-3">
                            <span class="badge bg-{{ $document->access_rights === 'public' ? 'success' : 'warning' }}">
                                {{ ucfirst($document->access_rights) }}
                            </span>
                        </dd>

                        @if($document->doi)
                            <dt class="small text-muted">DOI</dt>
                            <dd class="mb-0">{{ $document->doi }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partager ce document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">URL permanente</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $document->permanent_url }}" readonly>
                        <button class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ $document->permanent_url }}')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cite Modal -->
<div class="modal fade" id="citeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Citer ce document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="small">
                    {{ $document->user->name }} ({{ $document->year }}). {{ $document->title }}. 
                    {{ $document->documentType->name }}, École Normale Supérieure de Maroua. 
                    {{ $document->permanent_url }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
