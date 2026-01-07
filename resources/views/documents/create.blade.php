@extends('layouts.app')

@section('title', 'Déposer un document - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="fw-bold mb-0">Déposer un document</h1>
                    <p class="text-muted mb-0">Ajoutez un nouveau document aux archives</p>
                </div>
            </div>

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="depositForm">
                @csrf

                <!-- Document Type Selection -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-1-circle me-2"></i>Type de document</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="document_type_id" class="form-label fw-bold">Sélectionnez le type de document *</label>
                            <select
                                class="form-select @error('document_type_id') is-invalid @enderror"
                                id="document_type_id"
                                name="document_type_id"
                                required
                                onchange="updateRequiredFields()"
                            >
                                <option value="">-- Choisir un type --</option>
                                @foreach($documentTypes as $type)
                                    <option
                                        value="{{ $type->id }}"
                                        data-required-fields="{{ $type->required_fields }}"
                                        {{ old('document_type_id') == $type->id ? 'selected' : '' }}
                                    >
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('document_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Le type de document détermine les métadonnées requises</div>
                        </div>
                    </div>
                </div>

                <!-- General Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-2-circle me-2"></i>Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Titre *</label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="abstract" class="form-label fw-bold">Résumé *</label>
                            <textarea
                                class="form-control @error('abstract') is-invalid @enderror"
                                id="abstract"
                                name="abstract"
                                rows="5"
                                required
                            >{{ old('abstract') }}</textarea>
                            <div class="form-text">Décrivez brièvement le contenu du document</div>
                            @error('abstract')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="keywords" class="form-label fw-bold">Mots-clés *</label>
                                <input
                                    type="text"
                                    class="form-control @error('keywords') is-invalid @enderror"
                                    id="keywords"
                                    name="keywords_input"
                                    value="{{ old('keywords_input') }}"
                                    placeholder="Ex: éducation, sciences, recherche"
                                >
                                <div class="form-text">Séparez les mots-clés par des virgules</div>
                                @error('keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="keywords-container" class="mt-2"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="language" class="form-label fw-bold">Langue *</label>
                                <select
                                    class="form-select @error('language') is-invalid @enderror"
                                    id="language"
                                    name="language"
                                    required
                                >
                                    <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>Anglais</option>
                                    <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>Allemand</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label fw-bold">Année *</label>
                                <input
                                    type="number"
                                    class="form-control @error('year') is-invalid @enderror"
                                    id="year"
                                    name="year"
                                    value="{{ old('year', date('Y')) }}"
                                    min="1900"
                                    max="{{ date('Y') + 1 }}"
                                    required
                                >
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="academic_year" class="form-label fw-bold">Année académique</label>
                                <input
                                    type="text"
                                    class="form-control @error('academic_year') is-invalid @enderror"
                                    id="academic_year"
                                    name="academic_year"
                                    value="{{ old('academic_year') }}"
                                    placeholder="Ex: 2023-2024"
                                >
                                @error('academic_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="department_id" class="form-label fw-bold">Département</label>
                            <select
                                class="form-select @error('department_id') is-invalid @enderror"
                                id="department_id"
                                name="department_id"
                            >
                                <option value="">-- Non spécifié --</option>
                                @foreach($departments as $dept)
                                    <option
                                        value="{{ $dept->id }}"
                                        {{ old('department_id', auth()->user()->department_id) == $dept->id ? 'selected' : '' }}
                                    >
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dynamic Metadata Fields -->
                <div class="card mb-4" id="metadataCard" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-3-circle me-2"></i>Métadonnées spécifiques</h5>
                    </div>
                    <div class="card-body" id="metadataFields">
                        <!-- Dynamic fields will be inserted here -->
                    </div>
                </div>

                <!-- File Upload -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-4-circle me-2"></i>Fichier</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">Document (PDF uniquement) *</label>
                            <input
                                type="file"
                                class="form-control @error('file') is-invalid @enderror"
                                id="file"
                                name="file"
                                accept=".pdf"
                                required
                                onchange="displayFileInfo()"
                            >
                            <div class="form-text">Taille maximum : 20 Mo</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="fileInfo" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Access Rights -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-5-circle me-2"></i>Droits d'accès</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Type d'accès *</label>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="access_rights"
                                    id="access_public"
                                    value="public"
                                    {{ old('access_rights', 'public') == 'public' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="access_public">
                                    <strong>Public</strong> - Accessible à tous
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="access_rights"
                                    id="access_restricted"
                                    value="restricted"
                                    {{ old('access_rights') == 'restricted' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="access_restricted">
                                    <strong>Restreint</strong> - Accessible uniquement aux membres
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="access_rights"
                                    id="access_embargo"
                                    value="embargo"
                                    {{ old('access_rights') == 'embargo' ? 'checked' : '' }}
                                    onchange="toggleEmbargoDate()"
                                >
                                <label class="form-check-label" for="access_embargo">
                                    <strong>Embargo</strong> - Accès différé jusqu'à une date
                                </label>
                            </div>
                        </div>

                        <div id="embargoDateField" style="display: none;">
                            <label for="embargo_date" class="form-label fw-bold">Date de levée d'embargo</label>
                            <input
                                type="date"
                                class="form-control @error('embargo_date') is-invalid @enderror"
                                id="embargo_date"
                                name="embargo_date"
                                value="{{ old('embargo_date') }}"
                                min="{{ date('Y-m-d') }}"
                            >
                            @error('embargo_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Soumettre le document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Metadata field definitions
const metadataFields = {
    'supervisor': { label: 'Directeur/Superviseur', type: 'text', required: true },
    'co_supervisor': { label: 'Co-superviseur', type: 'text', required: false },
    'specialty': { label: 'Spécialité', type: 'text', required: true },
    'defense_date': { label: 'Date de soutenance', type: 'date', required: true },
    'jury': { label: 'Membres du jury', type: 'textarea', required: true },
    'director': { label: 'Directeur de thèse', type: 'text', required: true },
    'doctoral_school': { label: 'École doctorale', type: 'text', required: true },
    'journal': { label: 'Revue', type: 'text', required: true },
    'issn': { label: 'ISSN', type: 'text', required: true },
    'publication_status': { label: 'Statut de publication', type: 'select', required: true, options: ['Soumis', 'Accepté', 'Publié'] },
    'host_institution': { label: 'Structure d\'accueil', type: 'text', required: true },
    'stage_period': { label: 'Période du stage', type: 'text', required: true },
    'project_type': { label: 'Type de projet', type: 'text', required: true },
    'course_level': { label: 'Niveau', type: 'text', required: true },
    'semester': { label: 'Semestre', type: 'text', required: true },
    'course_type': { label: 'Type de cours', type: 'text', required: true },
    'event_name': { label: 'Nom de l\'événement', type: 'text', required: true },
    'event_date': { label: 'Date de l\'événement', type: 'date', required: true },
    'event_location': { label: 'Lieu de l\'événement', type: 'text', required: true },
    'issuing_body': { label: 'Organe émetteur', type: 'text', required: true },
    'report_period': { label: 'Période du rapport', type: 'text', required: true },
    'document_type': { label: 'Type de document', type: 'text', required: true },
    'issuing_authority': { label: 'Autorité émettrice', type: 'text', required: true },
    'data_type': { label: 'Type de données', type: 'text', required: true },
    'collection_method': { label: 'Méthode de collecte', type: 'text', required: true },
    'data_format': { label: 'Format des données', type: 'text', required: true }
};

function updateRequiredFields() {
    const select = document.getElementById('document_type_id');
    const selectedOption = select.options[select.selectedIndex];
    const requiredFields = selectedOption.getAttribute('data-required-fields');

    const metadataCard = document.getElementById('metadataCard');
    const metadataFieldsDiv = document.getElementById('metadataFields');

    if (requiredFields && requiredFields !== 'null') {
        const fields = JSON.parse(requiredFields);
        metadataFieldsDiv.innerHTML = '';

        fields.forEach(fieldName => {
            const field = metadataFields[fieldName];
            if (field) {
                const fieldHtml = createFieldHTML(fieldName, field);
                metadataFieldsDiv.innerHTML += fieldHtml;
            }
        });

        metadataCard.style.display = 'block';
    } else {
        metadataCard.style.display = 'none';
    }
}

function createFieldHTML(name, field) {
    const required = field.required ? 'required' : '';
    const asterisk = field.required ? '*' : '';

    if (field.type === 'textarea') {
        return `
            <div class="mb-3">
                <label for="metadata_${name}" class="form-label fw-bold">${field.label} ${asterisk}</label>
                <textarea
                    class="form-control"
                    id="metadata_${name}"
                    name="metadata[${name}]"
                    rows="3"
                    ${required}
                ></textarea>
            </div>
        `;
    } else if (field.type === 'select') {
        const options = field.options.map(opt => `<option value="${opt}">${opt}</option>`).join('');
        return `
            <div class="mb-3">
                <label for="metadata_${name}" class="form-label fw-bold">${field.label} ${asterisk}</label>
                <select
                    class="form-select"
                    id="metadata_${name}"
                    name="metadata[${name}]"
                    ${required}
                >
                    <option value="">-- Choisir --</option>
                    ${options}
                </select>
            </div>
        `;
    } else {
        return `
            <div class="mb-3">
                <label for="metadata_${name}" class="form-label fw-bold">${field.label} ${asterisk}</label>
                <input
                    type="${field.type}"
                    class="form-control"
                    id="metadata_${name}"
                    name="metadata[${name}]"
                    ${required}
                >
            </div>
        `;
    }
}

function toggleEmbargoDate() {
    const embargoDateField = document.getElementById('embargoDateField');
    const embargoRadio = document.getElementById('access_embargo');
    embargoDateField.style.display = embargoRadio.checked ? 'block' : 'none';
}

function displayFileInfo() {
    const fileInput = document.getElementById('file');
    const fileInfo = document.getElementById('fileInfo');

    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        fileInfo.innerHTML = `
            <div class="alert alert-info">
                <i class="bi bi-file-pdf me-2"></i>
                <strong>${file.name}</strong> (${sizeMB} Mo)
            </div>
        `;
    }
}

// Keywords handling
document.getElementById('keywords_input').addEventListener('input', function(e) {
    const keywords = e.target.value.split(',').map(k => k.trim()).filter(k => k.length > 0);
    const container = document.getElementById('keywords-container');

    container.innerHTML = keywords.map(keyword => `
        <span class="badge bg-primary me-2 mb-2">${keyword}</span>
    `).join('');

    // Create hidden input for keywords array
    const hiddenInputs = keywords.map((keyword, index) => `
        <input type="hidden" name="keywords[${index}]" value="${keyword}">
    `).join('');

    const existingHidden = document.querySelectorAll('input[name^="keywords["]');
    existingHidden.forEach(input => input.remove());

    container.innerHTML += hiddenInputs;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRequiredFields();
    toggleEmbargoDate();

    // Trigger keywords display if old value exists
    const keywordsInput = document.getElementById('keywords_input');
    if (keywordsInput.value) {
        keywordsInput.dispatchEvent(new Event('input'));
    }
});
</script>
@endsection
