@extends('layouts.app')

@section('title', 'Validation - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-clipboard-check me-2"></i>Validation des documents</h1>
            <p class="text-muted mb-0">{{ $pendingDocuments->total() }} document(s) en attente de validation</p>
        </div>
    </div>

    @if($pendingDocuments->count() > 0)
        @foreach($pendingDocuments as $document)
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge bg-warning">En attente</span>
                                <span class="badge bg-info">{{ $document->documentType->name }}</span>
                                @if($document->department)
                                    <span class="badge bg-secondary">{{ $document->department->code }}</span>
                                @endif
                            </div>

                            <h4 class="fw-bold mb-3">{{ $document->title }}</h4>

                            <p class="text-muted mb-3">{{ Str::limit($document->abstract, 300) }}</p>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <small class="text-muted d-block"><i class="bi bi-person me-2"></i><strong>Auteur:</strong></small>
                                    <p class="mb-0">{{ $document->user->name }}</p>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted d-block"><i class="bi bi-calendar me-2"></i><strong>Année:</strong></small>
                                    <p class="mb-0">{{ $document->year }}</p>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted d-block"><i class="bi bi-globe me-2"></i><strong>Langue:</strong></small>
                                    <p class="mb-0">{{ strtoupper($document->language) }}</p>
                                </div>
                            </div>

                            @if($document->keywords && count($document->keywords) > 0)
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2"><i class="bi bi-tags me-2"></i><strong>Mots-clés:</strong></small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($document->keywords as $keyword)
                                            <span class="badge bg-light text-dark">{{ $keyword }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="border-top pt-3 mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-2"></i>Déposé le {{ $document->created_at->format('d/m/Y à H:i') }}
                                    ({{ $document->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('validation.show', $document->arem_doc_id) }}" class="btn btn-primary">
                                    <i class="bi bi-eye me-2"></i>Examiner en détail
                                </a>

                                @if($document->file_path)
                                    <button class="btn btn-outline-secondary" onclick="alert('Fonction de téléchargement à implémenter')">
                                        <i class="bi bi-download me-2"></i>Télécharger le PDF
                                    </button>
                                @endif

                                <hr class="my-2">

                                <form action="{{ route('validation.approve', $document->arem_doc_id) }}" method="POST" onsubmit="return confirm('Confirmer la validation de ce document ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle me-2"></i>Valider
                                    </button>
                                </form>

                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#revisionModal{{ $document->id }}">
                                    <i class="bi bi-pencil me-2"></i>Demander révision
                                </button>

                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $document->id }}">
                                    <i class="bi bi-x-circle me-2"></i>Rejeter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revision Modal -->
            <div class="modal fade" id="revisionModal{{ $document->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('validation.requestRevision', $document->arem_doc_id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Demander une révision</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="comment{{ $document->id }}" class="form-label">Commentaires *</label>
                                    <textarea
                                        class="form-control"
                                        id="comment{{ $document->id }}"
                                        name="comment"
                                        rows="4"
                                        required
                                        placeholder="Décrivez les modifications nécessaires..."
                                    ></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Points à modifier</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="changes[]" value="title" id="change_title{{ $document->id }}">
                                        <label class="form-check-label" for="change_title{{ $document->id }}">Titre</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="changes[]" value="abstract" id="change_abstract{{ $document->id }}">
                                        <label class="form-check-label" for="change_abstract{{ $document->id }}">Résumé</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="changes[]" value="keywords" id="change_keywords{{ $document->id }}">
                                        <label class="form-check-label" for="change_keywords{{ $document->id }}">Mots-clés</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="changes[]" value="metadata" id="change_metadata{{ $document->id }}">
                                        <label class="form-check-label" for="change_metadata{{ $document->id }}">Métadonnées</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="changes[]" value="file" id="change_file{{ $document->id }}">
                                        <label class="form-check-label" for="change_file{{ $document->id }}">Fichier PDF</label>
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
            <div class="modal fade" id="rejectModal{{ $document->id }}" tabindex="-1">
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
                                    <label for="reject_comment{{ $document->id }}" class="form-label">Raison du rejet *</label>
                                    <textarea
                                        class="form-control"
                                        id="reject_comment{{ $document->id }}"
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
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $pendingDocuments->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-check-circle fs-1 text-success"></i>
            <h4 class="mt-3">Aucun document en attente</h4>
            <p class="text-muted">Tous les documents ont été traités !</p>
        </div>
    @endif
</div>
@endsection
