@extends('layouts.app')

@section('title', 'Administration - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-gear-fill me-2"></i>Administration</h1>
            <p class="text-muted mb-0">Gestion de la plateforme ArEM</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Utilisateurs</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\User::count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-people fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Documents Publiés</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Document::where('status', 'published')->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-file-check fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">En attente</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Document::where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-clock-history fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Départements</p>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Department::count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="bi bi-building fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Menu -->
    <div class="row g-4">
        <div class="col-lg-4">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-people fs-3 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Gestion des utilisateurs</h5>
                                <p class="text-muted mb-0 small">Gérer les comptes et rôles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('admin.departments') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="bi bi-building fs-3 text-success"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Gestion des départements</h5>
                                <p class="text-muted mb-0 small">Gérer les départements</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('admin.documentTypes') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="bi bi-tag fs-3 text-info"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Types de documents</h5>
                                <p class="text-muted mb-0 small">Gérer les types de documents</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('validation.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-file-check fs-3 text-warning"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Validation</h5>
                                <p class="text-muted mb-0 small">Documents en attente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('admin.statistics') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <i class="bi bi-graph-up fs-3 text-danger"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Statistiques</h5>
                                <p class="text-muted mb-0 small">Consulter les statistiques</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4">
            <a href="{{ route('documents.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-secondary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-files fs-3 text-secondary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Tous les documents</h5>
                                <p class="text-muted mb-0 small">Voir tous les documents</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card border-0 shadow-sm mt-5">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">Activité récente</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Document</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentDocuments = \App\Models\Document::with(['user', 'documentType'])
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();
                        @endphp
                        @foreach($recentDocuments as $doc)
                            <tr>
                                <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $doc->user->name }}</td>
                                <td>Dépôt de document</td>
                                <td>
                                    <a href="{{ route('documents.show', $doc->arem_doc_id) }}">
                                        {{ Str::limit($doc->title, 50) }}
                                    </a>
                                </td>
                                <td>
                                    @if($doc->status === 'published')
                                        <span class="badge bg-success">Publié</span>
                                    @elseif($doc->status === 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($doc->status === 'rejected')
                                        <span class="badge bg-danger">Rejeté</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($doc->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
}
</style>
@endsection
