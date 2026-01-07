@extends('layouts.app')

@section('title', 'Validation - ' . $document->title . ' - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('validation.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 class="fw-bold mb-0">Validation du document</h1>
            <p class="text-muted mb-0">{{ $document->arem_doc_id }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Document Details -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Détails du document</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-warning mb-2">En attente</span>
                        <span class="badge bg-info">{{ $document->documentType->name }}</span>
                    </div>

                    <h3 class="fw-bold mb-3">{{ $document->title }}</h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="small text-muted d-block">Auteur</label>
                            <p class="mb-0"><strong>{{ $document->user->name }}</strong></p>
                            <small class="text-muted">{{ $document->user->email }}</small>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted d-block">Année</label>
                            <p class="mb-0">{{ $document->year }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted d-block">Langue</label>
                            <p class="mb-0">{{ strtoupper($document->language) }}</p>
                        </div>
                        @if($document->department)
                            <div class="col-md-6">
                                <label class="small text-muted d-block">Département</label>
                                <p class="mb-0">{{ $document->department->name }}</p>
                            </div>
                        @endif
                        @if($document->academic_year)
                            <div class="col-md-6">
                                <label class="small text-muted d-block">Année académique</label>
                                <p class="mb-0">{{ $document->academic_year }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold mb-2">Résumé</label>
                        <p class="text-muted">{{ $document->abstract }}</p>
                    </div>

                    @if($document->keywords && count($document->keywords) > 0)
                        <div class="mb-4">
                            <label class="fw-bold mb-2">Mots-clés</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($document->keywords as $keyword)
                                    <span class="badge bg-light text-dark">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="fw-bold mb-2">Fichier</label>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-file-pdf fs-3 text-danger"></i>
                            <div>
                                <p class="mb-0"><strong>{{ $document->file_name }}</strong></p>
                                <small class="text-muted">{{ round($document->file_size / 1024 / 1024, 2) }} Mo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @if($document->metadata->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-tags me-2"></i>Métadonnées</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                @foreach($document->metadata as $meta)
                                    <tr>
                                        <th style="width: 30%">{{ ucfirst(str_replace('_', ' ', $meta->meta_key)) }}</th>
                                        <td>{{ $meta->meta_value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Validation History -->
            @if($document->validationWorkflows->count() > 0)
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historique de validation</h5>
                    </div>
                    <div class="card-body">
                        @foreach($document->validationWorkflows as $workflow)
                            <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    @if($workflow->action === 'approved')
                                        <i class="bi bi-check-circle fs-4 text-success"></i>
                                    @elseif($workflow->action === 'rejected')
                                        <i class="bi bi-x-circle fs-4 text-danger"></i>
                                    @else
                                        <i class="bi bi-pencil fs-4 text-warning"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1">
                                        <strong>{{ $workflow->user->name }}</strong>
                                        @if($workflow->action === 'approved')
                                            a approuvé le document
                                        @elseif($workflow->action === 'rejected')
                                            a rejeté le document
                                        @else
                                            a demandé une révision
                                        @endif
                                    </p>
                                    <small class="text-muted">{{ $workflow->created_at->diffForHumans() }}</small>
                                    @if($workflow->comment)
                                        <p class="mt-2 mb-0 text-muted">{{ $workflow->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 100px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <!-- Approve -->
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="bi bi-check-circle me-2"></i>Valider et publier
                        </button>

                        <!-- Request Revision -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#revisionModal">
                            <i class="bi bi-pencil me-2"></i>Demander une révision
                        </button>

                        <!-- Reject -->
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>Rejeter
                        </button>

                        <hr>

                        <!-- Download -->
                        <a href="{{ route('documents.download', $document->arem_doc_id) }}" class="btn btn-outline-primary">
                            <i class="bi bi-download me-2"></i>Télécharger le PDF
                        </a>

                        <!-- View Full -->
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-eye me-2"></i>Voir la page publique
                        </a>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        Déposé {{ $document->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('validation.approve', $document->arem_doc_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Valider et publier le document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous êtes sur le point de <strong>valider et publier</strong> ce document. Il sera accessible publiquement.</p>
                    <div class="mb-3">
                        <label for="approve_comment" class="form-label">Commentaires (optionnel)</label>
                        <textarea
                            class="form-control"
                            id="approve_comment"
                            name="comment"
                            rows="3"
                            placeholder="Ajoutez un commentaire pour l'auteur..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Valider et publier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Revision Modal -->
<div class="modal fade" id="revisionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('validation.requestRevision', $document->arem_doc_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Demander une révision</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="revision_comment" class="form-label">Commentaires *</label>
                        <textarea
                            class="form-control"
                            id="revision_comment"
                            name="comment"
                            rows="4"
                            required
                            placeholder="Décrivez les modifications nécessaires..."
                        ></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Points à modifier</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="changes[]" value="title" id="change_title">
                            <label class="form-check-label" for="change_title">Titre</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="changes[]" value="abstract" id="change_abstract">
                            <label class="form-check-label" for="change_abstract">Résumé</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="changes[]" value="keywords" id="change_keywords">
                            <label class="form-check-label" for="change_keywords">Mots-clés</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="changes[]" value="metadata" id="change_metadata">
                            <label class="form-check-label" for="change_metadata">Métadonnées</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="changes[]" value="file" id="change_file">
                            <label class="form-check-label" for="change_file">Fichier PDF</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Envoyer la demande</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('validation.reject', $document->arem_doc_id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Rejeter le document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Cette action rejettera définitivement le document. L'auteur sera notifié.
                    </div>
                    <div class="mb-3">
                        <label for="reject_comment" class="form-label">Raison du rejet *</label>
                        <textarea
                            class="form-control"
                            id="reject_comment"
                            name="comment"
                            rows="4"
                            required
                            placeholder="Expliquez pourquoi ce document est rejeté..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
