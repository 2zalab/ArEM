@extends('layouts.app')

@section('title', 'Gestion des types de documents - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0">Gestion des types de documents</h1>
            <p class="text-muted mb-0">Configuration des types de documents acceptés</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle me-2"></i>Nouveau type
            </button>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
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

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Liste des types de documents ({{ $documentTypes->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="8%">ID</th>
                            <th width="25%">Nom</th>
                            <th width="15%">Code</th>
                            <th width="12%">Documents</th>
                            <th width="25%">Champs requis</th>
                            <th width="10%">Statut</th>
                            <th width="5%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documentTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td><strong>{{ $type->name }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $type->code }}</span></td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $type->documents_count }} {{ Str::plural('document', $type->documents_count) }}
                                    </span>
                                </td>
                                <td>
                                    @if($type->required_fields && is_array($type->required_fields) && count($type->required_fields) > 0)
                                        <small class="text-muted">{{ count($type->required_fields) }} champ(s)</small>
                                        <div class="mt-1">
                                            @foreach(array_slice($type->required_fields, 0, 3) as $field)
                                                <span class="badge bg-light text-dark me-1">{{ $field }}</span>
                                            @endforeach
                                            @if(count($type->required_fields) > 3)
                                                <span class="badge bg-light text-dark">+{{ count($type->required_fields) - 3 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Aucun</span>
                                    @endif
                                </td>
                                <td>
                                    @if($type->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Actif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button"
                                                class="btn btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $type->id }}"
                                                title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $type->id }}"
                                                title="Supprimer"
                                                {{ $type->documents_count > 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $type->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Modifier le type de document</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.documentTypes.update', $type->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit_name{{ $type->id }}" class="form-label fw-bold">Nom *</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_name{{ $type->id }}"
                                                        name="name"
                                                        value="{{ $type->name }}"
                                                        required
                                                    >
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_code{{ $type->id }}" class="form-label fw-bold">Code *</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_code{{ $type->id }}"
                                                        name="code"
                                                        value="{{ $type->code }}"
                                                        maxlength="50"
                                                        required
                                                    >
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_description{{ $type->id }}" class="form-label fw-bold">Description</label>
                                                    <textarea
                                                        class="form-control"
                                                        id="edit_description{{ $type->id }}"
                                                        name="description"
                                                        rows="2"
                                                    >{{ $type->description }}</textarea>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        id="edit_is_active{{ $type->id }}"
                                                        name="is_active"
                                                        value="1"
                                                        {{ $type->is_active ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="edit_is_active{{ $type->id }}">
                                                        Type de document actif
                                                    </label>
                                                </div>
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <small>Les champs requis doivent être modifiés via le seeder ou la console pour garantir la cohérence.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-2"></i>Enregistrer
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $type->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirmer la suppression</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Êtes-vous sûr de vouloir supprimer le type <strong>{{ $type->name }}</strong> ?</p>
                                            @if($type->documents_count > 0)
                                                <div class="alert alert-warning">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    Ce type contient {{ $type->documents_count }} document(s) et ne peut pas être supprimé.
                                                </div>
                                            @else
                                                <p class="text-muted small">Cette action est irréversible.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            @if($type->documents_count == 0)
                                                <form action="{{ route('admin.documentTypes.delete', $type->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-trash me-2"></i>Supprimer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    Aucun type de document trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nouveau type de document</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.documentTypes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nom *</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex: Mémoire de Master"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label fw-bold">Code *</label>
                        <input
                            type="text"
                            class="form-control @error('code') is-invalid @enderror"
                            id="code"
                            name="code"
                            value="{{ old('code') }}"
                            maxlength="50"
                            placeholder="Ex: memoire_master"
                            required
                        >
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Code unique pour identifier le type (lettres, chiffres, tirets du bas)</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea
                            class="form-control"
                            id="description"
                            name="description"
                            rows="2"
                            placeholder="Description du type de document"
                        >{{ old('description') }}</textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Les champs requis peuvent être configurés après création via le seeder ou la console.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Show create modal if there are validation errors
@if($errors->any())
    var createModal = new bootstrap.Modal(document.getElementById('createModal'));
    createModal.show();
@endif
</script>
@endsection
