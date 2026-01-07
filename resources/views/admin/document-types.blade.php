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

                                                <!-- Champs requis -->
                                                @php
                                                    $typeFields = is_array($type->required_fields) ? $type->required_fields : [];
                                                @endphp

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Champs de métadonnées requis</label>
                                                    <div class="form-text mb-2">Sélectionnez les champs qui seront obligatoires lors du dépôt de ce type de document</div>
                                                    <div class="small text-muted mb-2">
                                                        <strong>Actuellement sélectionnés :</strong> {{ count($typeFields) }} champ(s)
                                                    </div>

                                                    <div class="accordion" id="editFieldsAccordion{{ $type->id }}">
                                                        <!-- Mémoires et Thèses -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editFieldsMemoires{{ $type->id }}">
                                                                    Mémoires et Thèses
                                                                </button>
                                                            </h2>
                                                            <div id="editFieldsMemoires{{ $type->id }}" class="accordion-collapse collapse" data-bs-parent="#editFieldsAccordion{{ $type->id }}">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="supervisor" id="edit_supervisor_{{ $type->id }}" {{ in_array('supervisor', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_supervisor_{{ $type->id }}">Directeur/Superviseur</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="co_supervisor" id="edit_co_supervisor_{{ $type->id }}" {{ in_array('co_supervisor', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_co_supervisor_{{ $type->id }}">Co-superviseur</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="specialty" id="edit_specialty_{{ $type->id }}" {{ in_array('specialty', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_specialty_{{ $type->id }}">Spécialité</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="defense_date" id="edit_defense_date_{{ $type->id }}" {{ in_array('defense_date', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_defense_date_{{ $type->id }}">Date de soutenance</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="jury" id="edit_jury_{{ $type->id }}" {{ in_array('jury', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_jury_{{ $type->id }}">Membres du jury</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="director" id="edit_director_{{ $type->id }}" {{ in_array('director', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_director_{{ $type->id }}">Directeur de thèse</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="doctoral_school" id="edit_doctoral_school_{{ $type->id }}" {{ in_array('doctoral_school', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_doctoral_school_{{ $type->id }}">École doctorale</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Articles scientifiques -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editFieldsArticles{{ $type->id }}">
                                                                    Articles scientifiques
                                                                </button>
                                                            </h2>
                                                            <div id="editFieldsArticles{{ $type->id }}" class="accordion-collapse collapse" data-bs-parent="#editFieldsAccordion{{ $type->id }}">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="journal" id="edit_journal_{{ $type->id }}" {{ in_array('journal', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_journal_{{ $type->id }}">Nom de la revue</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="issn" id="edit_issn_{{ $type->id }}" {{ in_array('issn', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_issn_{{ $type->id }}">ISSN</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="doi" id="edit_doi_{{ $type->id }}" {{ in_array('doi', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_doi_{{ $type->id }}">DOI</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="volume" id="edit_volume_{{ $type->id }}" {{ in_array('volume', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_volume_{{ $type->id }}">Volume</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="issue" id="edit_issue_{{ $type->id }}" {{ in_array('issue', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_issue_{{ $type->id }}">Numéro</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="pages" id="edit_pages_{{ $type->id }}" {{ in_array('pages', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_pages_{{ $type->id }}">Pages</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="publication_date" id="edit_publication_date_{{ $type->id }}" {{ in_array('publication_date', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_publication_date_{{ $type->id }}">Date de publication</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="publication_status" id="edit_publication_status_{{ $type->id }}" {{ in_array('publication_status', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_publication_status_{{ $type->id }}">Statut de publication</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Stages et Projets -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editFieldsStages{{ $type->id }}">
                                                                    Stages et Projets
                                                                </button>
                                                            </h2>
                                                            <div id="editFieldsStages{{ $type->id }}" class="accordion-collapse collapse" data-bs-parent="#editFieldsAccordion{{ $type->id }}">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="host_institution" id="edit_host_institution_{{ $type->id }}" {{ in_array('host_institution', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_host_institution_{{ $type->id }}">Structure d'accueil</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="stage_period" id="edit_stage_period_{{ $type->id }}" {{ in_array('stage_period', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_stage_period_{{ $type->id }}">Période du stage</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="stage_supervisor" id="edit_stage_supervisor_{{ $type->id }}" {{ in_array('stage_supervisor', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_stage_supervisor_{{ $type->id }}">Maître de stage</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="project_type" id="edit_project_type_{{ $type->id }}" {{ in_array('project_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_project_type_{{ $type->id }}">Type de projet</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="partners" id="edit_partners_{{ $type->id }}" {{ in_array('partners', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_partners_{{ $type->id }}">Partenaires</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Cours et Communications -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editFieldsCours{{ $type->id }}">
                                                                    Cours et Communications
                                                                </button>
                                                            </h2>
                                                            <div id="editFieldsCours{{ $type->id }}" class="accordion-collapse collapse" data-bs-parent="#editFieldsAccordion{{ $type->id }}">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="course_level" id="edit_course_level_{{ $type->id }}" {{ in_array('course_level', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_course_level_{{ $type->id }}">Niveau</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="semester" id="edit_semester_{{ $type->id }}" {{ in_array('semester', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_semester_{{ $type->id }}">Semestre</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="course_type" id="edit_course_type_{{ $type->id }}" {{ in_array('course_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_course_type_{{ $type->id }}">Type de cours</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="credits" id="edit_credits_{{ $type->id }}" {{ in_array('credits', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_credits_{{ $type->id }}">Crédits</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_name" id="edit_event_name_{{ $type->id }}" {{ in_array('event_name', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_event_name_{{ $type->id }}">Nom de l'événement</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_date" id="edit_event_date_{{ $type->id }}" {{ in_array('event_date', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_event_date_{{ $type->id }}">Date de l'événement</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_location" id="edit_event_location_{{ $type->id }}" {{ in_array('event_location', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_event_location_{{ $type->id }}">Lieu de l'événement</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="presentation_type" id="edit_presentation_type_{{ $type->id }}" {{ in_array('presentation_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_presentation_type_{{ $type->id }}">Type de présentation</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Documents administratifs et Données -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editFieldsAdmin{{ $type->id }}">
                                                                    Documents administratifs et Données
                                                                </button>
                                                            </h2>
                                                            <div id="editFieldsAdmin{{ $type->id }}" class="accordion-collapse collapse" data-bs-parent="#editFieldsAccordion{{ $type->id }}">
                                                                <div class="accordion-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="issuing_body" id="edit_issuing_body_{{ $type->id }}" {{ in_array('issuing_body', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_issuing_body_{{ $type->id }}">Organe émetteur</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="report_period" id="edit_report_period_{{ $type->id }}" {{ in_array('report_period', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_report_period_{{ $type->id }}">Période du rapport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="report_type" id="edit_report_type_{{ $type->id }}" {{ in_array('report_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_report_type_{{ $type->id }}">Type de rapport</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="document_type" id="edit_document_type_{{ $type->id }}" {{ in_array('document_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_document_type_{{ $type->id }}">Type de document</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="issuing_authority" id="edit_issuing_authority_{{ $type->id }}" {{ in_array('issuing_authority', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_issuing_authority_{{ $type->id }}">Autorité émettrice</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="reference_number" id="edit_reference_number_{{ $type->id }}" {{ in_array('reference_number', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_reference_number_{{ $type->id }}">Numéro de référence</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="data_type" id="edit_data_type_{{ $type->id }}" {{ in_array('data_type', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_data_type_{{ $type->id }}">Type de données</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="collection_method" id="edit_collection_method_{{ $type->id }}" {{ in_array('collection_method', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_collection_method_{{ $type->id }}">Méthode de collecte</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="data_format" id="edit_data_format_{{ $type->id }}" {{ in_array('data_format', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_data_format_{{ $type->id }}">Format des données</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="sample_size" id="edit_sample_size_{{ $type->id }}" {{ in_array('sample_size', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_sample_size_{{ $type->id }}">Taille de l'échantillon</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="required_fields[]" value="collection_period" id="edit_collection_period_{{ $type->id }}" {{ in_array('collection_period', $typeFields) ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="edit_collection_period_{{ $type->id }}">Période de collecte</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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

                    <!-- Champs requis -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Champs de métadonnées requis</label>
                        <div class="form-text mb-2">Sélectionnez les champs qui seront obligatoires lors du dépôt de ce type de document</div>

                        <div class="accordion" id="fieldsAccordion">
                            <!-- Mémoires et Thèses -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fieldsMemoires">
                                        Mémoires et Thèses
                                    </button>
                                </h2>
                                <div id="fieldsMemoires" class="accordion-collapse collapse" data-bs-parent="#fieldsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="supervisor" id="field_supervisor">
                                                    <label class="form-check-label" for="field_supervisor">Directeur/Superviseur</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="co_supervisor" id="field_co_supervisor">
                                                    <label class="form-check-label" for="field_co_supervisor">Co-superviseur</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="specialty" id="field_specialty">
                                                    <label class="form-check-label" for="field_specialty">Spécialité</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="defense_date" id="field_defense_date">
                                                    <label class="form-check-label" for="field_defense_date">Date de soutenance</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="jury" id="field_jury">
                                                    <label class="form-check-label" for="field_jury">Membres du jury</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="director" id="field_director">
                                                    <label class="form-check-label" for="field_director">Directeur de thèse</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="doctoral_school" id="field_doctoral_school">
                                                    <label class="form-check-label" for="field_doctoral_school">École doctorale</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Articles scientifiques -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fieldsArticles">
                                        Articles scientifiques
                                    </button>
                                </h2>
                                <div id="fieldsArticles" class="accordion-collapse collapse" data-bs-parent="#fieldsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="journal" id="field_journal">
                                                    <label class="form-check-label" for="field_journal">Nom de la revue</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="issn" id="field_issn">
                                                    <label class="form-check-label" for="field_issn">ISSN</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="doi" id="field_doi">
                                                    <label class="form-check-label" for="field_doi">DOI</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="volume" id="field_volume">
                                                    <label class="form-check-label" for="field_volume">Volume</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="issue" id="field_issue">
                                                    <label class="form-check-label" for="field_issue">Numéro</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="pages" id="field_pages">
                                                    <label class="form-check-label" for="field_pages">Pages</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="publication_date" id="field_publication_date">
                                                    <label class="form-check-label" for="field_publication_date">Date de publication</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="publication_status" id="field_publication_status">
                                                    <label class="form-check-label" for="field_publication_status">Statut de publication</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stages et Projets -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fieldsStages">
                                        Stages et Projets
                                    </button>
                                </h2>
                                <div id="fieldsStages" class="accordion-collapse collapse" data-bs-parent="#fieldsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="host_institution" id="field_host_institution">
                                                    <label class="form-check-label" for="field_host_institution">Structure d'accueil</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="stage_period" id="field_stage_period">
                                                    <label class="form-check-label" for="field_stage_period">Période du stage</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="stage_supervisor" id="field_stage_supervisor">
                                                    <label class="form-check-label" for="field_stage_supervisor">Maître de stage</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="project_type" id="field_project_type">
                                                    <label class="form-check-label" for="field_project_type">Type de projet</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="partners" id="field_partners">
                                                    <label class="form-check-label" for="field_partners">Partenaires</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cours et Communications -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fieldsCours">
                                        Cours et Communications
                                    </button>
                                </h2>
                                <div id="fieldsCours" class="accordion-collapse collapse" data-bs-parent="#fieldsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="course_level" id="field_course_level">
                                                    <label class="form-check-label" for="field_course_level">Niveau</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="semester" id="field_semester">
                                                    <label class="form-check-label" for="field_semester">Semestre</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="course_type" id="field_course_type">
                                                    <label class="form-check-label" for="field_course_type">Type de cours</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="credits" id="field_credits">
                                                    <label class="form-check-label" for="field_credits">Crédits</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_name" id="field_event_name">
                                                    <label class="form-check-label" for="field_event_name">Nom de l'événement</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_date" id="field_event_date">
                                                    <label class="form-check-label" for="field_event_date">Date de l'événement</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="event_location" id="field_event_location">
                                                    <label class="form-check-label" for="field_event_location">Lieu de l'événement</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="presentation_type" id="field_presentation_type">
                                                    <label class="form-check-label" for="field_presentation_type">Type de présentation</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents administratifs et Données -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fieldsAdmin">
                                        Documents administratifs et Données
                                    </button>
                                </h2>
                                <div id="fieldsAdmin" class="accordion-collapse collapse" data-bs-parent="#fieldsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="issuing_body" id="field_issuing_body">
                                                    <label class="form-check-label" for="field_issuing_body">Organe émetteur</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="report_period" id="field_report_period">
                                                    <label class="form-check-label" for="field_report_period">Période du rapport</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="report_type" id="field_report_type">
                                                    <label class="form-check-label" for="field_report_type">Type de rapport</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="document_type" id="field_document_type">
                                                    <label class="form-check-label" for="field_document_type">Type de document</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="issuing_authority" id="field_issuing_authority">
                                                    <label class="form-check-label" for="field_issuing_authority">Autorité émettrice</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="reference_number" id="field_reference_number">
                                                    <label class="form-check-label" for="field_reference_number">Numéro de référence</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="data_type" id="field_data_type">
                                                    <label class="form-check-label" for="field_data_type">Type de données</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="collection_method" id="field_collection_method">
                                                    <label class="form-check-label" for="field_collection_method">Méthode de collecte</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="data_format" id="field_data_format">
                                                    <label class="form-check-label" for="field_data_format">Format des données</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="sample_size" id="field_sample_size">
                                                    <label class="form-check-label" for="field_sample_size">Taille de l'échantillon</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="required_fields[]" value="collection_period" id="field_collection_period">
                                                    <label class="form-check-label" for="field_collection_period">Période de collecte</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
