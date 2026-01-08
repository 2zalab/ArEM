@extends('layouts.app')

@section('title', 'Mes documents - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-person fs-1 text-primary"></i>
                            </div>
                        @endif
                        <h5 class="fw-bold mt-3 mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->department)
                            <p class="text-muted small mb-0">{{ Auth::user()->department->name }}</p>
                        @endif
                    </div>

                    <div class="border-top pt-3">
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        @if(Auth::user()->arem_id)
                            <small class="text-muted d-block">ID: {{ Auth::user()->arem_id }}</small>
                        @endif
                    </div>

                    <hr>

                    <nav class="nav flex-column">
                        <a href="{{ route('profile.documents') }}" class="nav-link active">
                            <i class="bi bi-files me-2"></i>Mes documents
                        </a>
                        <a href="{{ route('profile.cv') }}" class="nav-link">
                            <i class="bi bi-file-person me-2"></i>Mon CV
                        </a>
                        <a href="{{ route('profile.edit') }}" class="nav-link">
                            <i class="bi bi-person-gear me-2"></i>Modifier le profil
                        </a>
                        @if(Auth::user()->canValidateDocuments())
                            <a href="{{ route('validation.index') }}" class="nav-link">
                                <i class="bi bi-clipboard-check me-2"></i>Validation
                            </a>
                        @endif
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.index') }}" class="nav-link">
                                <i class="bi bi-gear me-2"></i>Administration
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Mes documents</h2>
                    <p class="text-muted mb-0">{{ $documents->total() }} document(s)</p>
                </div>
                <a href="{{ route('documents.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nouveau document
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                @php
                    $stats = [
                        'draft' => $documents->where('status', 'draft')->count(),
                        'pending' => $documents->where('status', 'pending')->count(),
                        'published' => $documents->where('status', 'published')->count(),
                        'rejected' => $documents->where('status', 'rejected')->count(),
                    ];
                @endphp
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Brouillons</p>
                                    <h4 class="fw-bold mb-0">{{ $stats['draft'] }}</h4>
                                </div>
                                <i class="bi bi-file-earmark fs-3 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">En attente</p>
                                    <h4 class="fw-bold mb-0">{{ $stats['pending'] }}</h4>
                                </div>
                                <i class="bi bi-clock fs-3 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Publiés</p>
                                    <h4 class="fw-bold mb-0">{{ $stats['published'] }}</h4>
                                </div>
                                <i class="bi bi-check-circle fs-3 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 small">Rejetés</p>
                                    <h4 class="fw-bold mb-0">{{ $stats['rejected'] }}</h4>
                                </div>
                                <i class="bi bi-x-circle fs-3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents List -->
            @forelse($documents as $document)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <div class="d-flex gap-2 mb-2">
                                    @if($document->status === 'published')
                                        <span class="badge bg-success">Publié</span>
                                    @elseif($document->status === 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($document->status === 'rejected')
                                        <span class="badge bg-danger">Rejeté</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($document->status) }}</span>
                                    @endif
                                    <span class="badge bg-info">{{ $document->documentType->name }}</span>
                                </div>

                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none text-dark">
                                        {{ $document->title }}
                                    </a>
                                </h5>

                                <p class="text-muted small mb-2">
                                    {{ Str::limit($document->abstract, 150) }}
                                </p>

                                <div class="d-flex flex-wrap gap-3 small text-muted">
                                    <span><i class="bi bi-calendar me-1"></i>{{ $document->year }}</span>
                                    @if($document->department)
                                        <span><i class="bi bi-building me-1"></i>{{ $document->department->name }}</span>
                                    @endif
                                    <span><i class="bi bi-clock me-1"></i>Déposé {{ $document->created_at->diffForHumans() }}</span>
                                    @if($document->status === 'published')
                                        <span><i class="bi bi-eye me-1"></i>{{ $document->getTotalViews() }} vues</span>
                                        <span><i class="bi bi-download me-1"></i>{{ $document->getTotalDownloads() }} téléchargements</span>
                                    @endif
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-link text-dark" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('documents.show', $document->arem_doc_id) }}">
                                            <i class="bi bi-eye me-2"></i>Voir
                                        </a>
                                    </li>
                                    @if(in_array($document->status, ['draft', 'rejected']))
                                        <li>
                                            <a class="dropdown-item" href="{{ route('documents.edit', $document->arem_doc_id) }}">
                                                <i class="bi bi-pencil me-2"></i>Modifier
                                            </a>
                                        </li>
                                    @endif
                                    @if($document->status !== 'published')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('documents.destroy', $document->arem_doc_id) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if($document->validated_at && $document->validator)
                            <div class="alert alert-success alert-sm mb-0 mt-3">
                                <i class="bi bi-check-circle me-2"></i>
                                <small>Validé par {{ $document->validator->name }} le {{ $document->validated_at->format('d/m/Y') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <h5 class="mt-3">Aucun document</h5>
                        <p class="text-muted">Vous n'avez pas encore déposé de document.</p>
                        <a href="{{ route('documents.create') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-2"></i>Déposer mon premier document
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
