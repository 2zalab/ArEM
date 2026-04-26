@extends('layouts.app')

@section('title', 'Gestion des documents - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-files me-2"></i>Gestion des documents</h1>
            <p class="text-muted mb-0">Gérer la visibilité des documents publiés</p>
        </div>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour au tableau de bord
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.documents') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Recherche</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Titre ou identifiant AREM..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publiés</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>Validés</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetés</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillons</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Visibilité</label>
                    <select name="visibility" class="form-select">
                        <option value="">Tous</option>
                        <option value="visible" {{ request('visibility') === 'visible' ? 'selected' : '' }}>Visibles</option>
                        <option value="hidden" {{ request('visibility') === 'hidden' ? 'selected' : '' }}>Masqués</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.documents') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des documents -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-list-ul me-2"></i>Documents ({{ $documents->total() }})
            </h5>
            <div class="d-flex gap-2">
                <span class="badge bg-success bg-opacity-75 px-3 py-2">
                    <i class="bi bi-eye me-1"></i>
                    {{ $documents->getCollection()->where('is_hidden', false)->count() }} visible(s) sur cette page
                </span>
                <span class="badge bg-secondary bg-opacity-75 px-3 py-2">
                    <i class="bi bi-eye-slash me-1"></i>
                    {{ $documents->getCollection()->where('is_hidden', true)->count() }} masqué(s) sur cette page
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px">ID</th>
                            <th>Document</th>
                            <th>Auteur</th>
                            <th>Département</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Visibilité</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 160px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                            <tr class="{{ $document->is_hidden ? 'table-secondary' : '' }}">
                                <td>
                                    <small class="text-muted font-monospace">{{ $document->arem_doc_id }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-start gap-2">
                                        @if($document->is_hidden)
                                            <i class="bi bi-eye-slash text-secondary mt-1" title="Document masqué"></i>
                                        @endif
                                        <div>
                                            <a href="{{ route('documents.show', $document->arem_doc_id) }}"
                                               class="fw-semibold text-decoration-none {{ $document->is_hidden ? 'text-muted' : '' }}"
                                               target="_blank">
                                                {{ Str::limit($document->title, 60) }}
                                            </a>
                                            @if($document->documentType)
                                                <br>
                                                <small class="text-muted">{{ $document->documentType->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($document->user)
                                        <span class="text-muted small">{{ $document->user->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($document->department)
                                        <span class="badge bg-light text-dark">{{ $document->department->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @switch($document->status)
                                        @case('published')
                                            <span class="badge bg-success">Publié</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                            @break
                                        @case('validated')
                                            <span class="badge bg-info text-dark">Validé</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Rejeté</span>
                                            @break
                                        @case('draft')
                                            <span class="badge bg-secondary">Brouillon</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($document->status) }}</span>
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    @if($document->is_hidden)
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-eye-slash me-1"></i>Masqué
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-75">
                                            <i class="bi bi-eye me-1"></i>Visible
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $document->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('documents.show', $document->arem_doc_id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Voir le document"
                                           target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <!-- Toggle Visibility Button -->
                                        <button type="button"
                                                class="btn btn-sm {{ $document->is_hidden ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#toggleModal{{ $document->id }}"
                                                title="{{ $document->is_hidden ? 'Démasquer le document' : 'Masquer le document' }}">
                                            <i class="bi {{ $document->is_hidden ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Toggle Visibility Modal -->
                            <div class="modal fade" id="toggleModal{{ $document->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header {{ $document->is_hidden ? 'bg-success' : 'bg-secondary' }} text-white">
                                            <h5 class="modal-title">
                                                <i class="bi {{ $document->is_hidden ? 'bi-eye' : 'bi-eye-slash' }} me-2"></i>
                                                {{ $document->is_hidden ? 'Démasquer le document' : 'Masquer le document' }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($document->is_hidden)
                                                <p>Voulez-vous rendre le document <strong>{{ $document->title }}</strong> à nouveau visible pour les utilisateurs ?</p>
                                                <p class="text-muted small">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Le document redeviendra accessible aux utilisateurs selon son statut et ses droits d'accès habituels.
                                                </p>
                                            @else
                                                <p>Voulez-vous masquer le document <strong>{{ $document->title }}</strong> ?</p>
                                                <div class="alert alert-warning py-2">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    Une fois masqué, les utilisateurs ne pourront plus visualiser ce document.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                            <form action="{{ route('admin.documents.toggleVisibility', $document->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn {{ $document->is_hidden ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="bi {{ $document->is_hidden ? 'bi-eye' : 'bi-eye-slash' }} me-2"></i>
                                                    {{ $document->is_hidden ? 'Démasquer' : 'Masquer' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Aucun document trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($documents->hasPages())
            <div class="card-footer bg-white">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
