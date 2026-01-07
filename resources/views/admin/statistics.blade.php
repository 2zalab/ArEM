@extends('layouts.app')

@section('title', 'Statistiques - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0">Statistiques avancées</h1>
            <p class="text-muted mb-0">Vue d'ensemble des données de la plateforme</p>
        </div>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour au tableau de bord
        </a>
    </div>

    <!-- Global Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_users'] }}</h3>
                    <p class="text-muted mb-0">Utilisateurs</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text fs-1 text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_documents'] }}</h3>
                    <p class="text-muted mb-0">Documents totaux</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-check-circle fs-1 text-info"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['published_documents'] }}</h3>
                    <p class="text-muted mb-0">Publiés</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-clock-history fs-1 text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['pending_documents'] }}</h3>
                    <p class="text-muted mb-0">En attente</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-x-circle fs-1 text-danger"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['rejected_documents'] }}</h3>
                    <p class="text-muted mb-0">Rejetés</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-building fs-1 text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_departments'] }}</h3>
                    <p class="text-muted mb-0">Départements</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark fs-1 text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_document_types'] }}</h3>
                    <p class="text-muted mb-0">Types de documents</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-graph-up fs-1 text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">
                        @if($stats['total_documents'] > 0)
                            {{ number_format(($stats['published_documents'] / $stats['total_documents']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </h3>
                    <p class="text-muted mb-0">Taux de publication</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Users by Role -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>Utilisateurs par rôle</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rôle</th>
                                    <th class="text-end">Nombre</th>
                                    <th class="text-end">Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users_by_role as $roleData)
                                    <tr>
                                        <td>
                                            @switch($roleData->role)
                                                @case('admin')
                                                    <span class="badge bg-danger">Administrateur</span>
                                                    @break
                                                @case('moderator')
                                                    <span class="badge bg-warning text-dark">Modérateur</span>
                                                    @break
                                                @case('depositor')
                                                    <span class="badge bg-primary">Déposant</span>
                                                    @break
                                                @case('reader')
                                                    <span class="badge bg-secondary">Lecteur</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="text-end"><strong>{{ $roleData->count }}</strong></td>
                                        <td class="text-end">
                                            {{ number_format(($roleData->count / $stats['total_users']) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents by Type -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Documents par type (Top 10)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Type</th>
                                    <th class="text-end">Documents</th>
                                    <th width="30%">Répartition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents_by_type as $type)
                                    <tr>
                                        <td>{{ $type->name }}</td>
                                        <td class="text-end"><strong>{{ $type->documents_count }}</strong></td>
                                        <td>
                                            @php
                                                $percentage = $stats['total_documents'] > 0 ? ($type->documents_count / $stats['total_documents']) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ $percentage }}%"
                                                     aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucune donnée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents by Department -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Documents par département (Top 10)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Département</th>
                                    <th class="text-end">Documents</th>
                                    <th width="30%">Répartition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents_by_department as $dept)
                                    <tr>
                                        <td>{{ $dept->name }}</td>
                                        <td class="text-end"><strong>{{ $dept->documents_count }}</strong></td>
                                        <td>
                                            @php
                                                $percentage = $stats['total_documents'] > 0 ? ($dept->documents_count / $stats['total_documents']) * 100 : 0;
                                            @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                     style="width: {{ $percentage }}%"
                                                     aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucune donnée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Utilisateurs récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_users as $user)
                                    <tr>
                                        <td>
                                            <strong>{{ $user->name }}</strong><br>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            @switch($user->role)
                                                @case('admin')
                                                    <span class="badge bg-danger">Admin</span>
                                                    @break
                                                @case('moderator')
                                                    <span class="badge bg-warning text-dark">Modérateur</span>
                                                    @break
                                                @case('depositor')
                                                    <span class="badge bg-primary">Déposant</span>
                                                    @break
                                                @case('reader')
                                                    <span class="badge bg-secondary">Lecteur</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $user->created_at->format('d/m/Y') }}<br>
                                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucun utilisateur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
