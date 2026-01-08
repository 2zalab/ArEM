@extends('layouts.app')

@section('title', 'Déposer un document - ArEM')

@section('styles')
<style>
    /* Progress Indicator */
    .progress-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 3rem;
        padding: 0 2rem;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .progress-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #e9ecef;
        z-index: 0;
    }

    .progress-step.active:not(:last-child)::after {
        background: linear-gradient(90deg, #0040A0 0%, #5AC8FA 100%);
    }

    .progress-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .progress-step.active .progress-circle {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        transform: scale(1.1);
    }

    .progress-label {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
        text-align: center;
        font-weight: 500;
    }

    .progress-step.active .progress-label {
        color: #0040A0;
        font-weight: 600;
    }

    .step-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .step-header {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .step-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        margin-right: 12px;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .step-card .card-body {
        padding: 2rem 1.5rem;
    }

    .form-label.fw-bold {
        color: #0040A0;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #5AC8FA;
        box-shadow: 0 0 0 0.25rem rgba(90, 200, 250, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border: none;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5AC8FA 0%, #0040A0 100%);
    }

    .btn-outline-primary {
        color: #0040A0;
        border-color: #0040A0;
        border-width: 2px;
        font-weight: 600;
    }

    .btn-outline-primary:hover {
        background-color: #0040A0;
        border-color: #0040A0;
        color: white;
    }

    .btn-outline-secondary {
        border-width: 2px;
        font-weight: 500;
    }

    .author-card {
        border: 2px solid #e9ecef;
        border-radius: 8px;
    }

    .keyword-badge {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .keyword-badge i {
        margin-left: 0.5rem;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .keyword-badge i:hover {
        opacity: 1;
    }

    .form-check-input:checked {
        background-color: #0040A0;
        border-color: #0040A0;
    }

    .form-check-input:focus {
        border-color: #5AC8FA;
        box-shadow: 0 0 0 0.25rem rgba(90, 200, 250, 0.25);
    }

    .page-header {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .page-header h1 {
        color: #0040A0;
    }

    .alert-info {
        background-color: rgba(90, 200, 250, 0.1);
        border-color: #5AC8FA;
        color: #0040A0;
    }

    .file-info-alert {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        border: 2px solid #5AC8FA;
        border-radius: 8px;
        padding: 1rem;
        color: #0040A0;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="page-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-0">Déposer un document</h1>
                        <p class="text-muted mb-0">Ajoutez un nouveau document aux archives</p>
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-step active" data-step="1">
                    <div class="progress-circle">1</div>
                    <div class="progress-label">Type</div>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="progress-circle">2</div>
                    <div class="progress-label">Informations</div>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="progress-circle">3</div>
                    <div class="progress-label">Métadonnées</div>
                </div>
                <div class="progress-step" data-step="4">
                    <div class="progress-circle">4</div>
                    <div class="progress-label">Fichier</div>
                </div>
                <div class="progress-step" data-step="5">
                    <div class="progress-circle">5</div>
                    <div class="progress-label">Accès</div>
                </div>
            </div>

            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="depositForm">
                @csrf

                <!-- Document Type Selection -->
                <div class="card step-card mb-4" data-step-content="1">
                    <div class="card-header step-header">
                        <h5><span class="step-number">1</span>Type de document</h5>
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
                                        data-required-fields="{{ is_null($type->required_fields) ? 'null' : json_encode($type->required_fields) }}"
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
                <div class="card step-card mb-4" data-step-content="2" style="display: none;">
                    <div class="card-header step-header">
                        <h5><span class="step-number">2</span>Informations générales</h5>
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

                        <!-- Auteurs -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Auteurs *</label>
                            <div class="form-text mb-2">Ajoutez les auteurs du document avec leurs institutions</div>

                            <div id="authors-container">
                                <!-- Les auteurs seront ajoutés ici -->
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addAuthor()">
                                <i class="bi bi-plus-circle me-1"></i>Ajouter un auteur
                            </button>

                            @error('authors')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                <label for="keywords_input" class="form-label fw-bold">Mots-clés *</label>
                                <input
                                    type="text"
                                    class="form-control @error('keywords') is-invalid @enderror"
                                    id="keywords_input"
                                    placeholder="Tapez un mot-clé et appuyez sur Entrée ou virgule"
                                >
                                <div class="form-text">Appuyez sur Entrée ou tapez une virgule pour ajouter un mot-clé</div>
                                @error('keywords')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div id="keywords-badges" class="mt-2"></div>
                                <div id="keywords-inputs"></div>
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
                <div class="card step-card mb-4" id="metadataCard" data-step-content="3" style="display: none;">
                    <div class="card-header step-header">
                        <h5><span class="step-number">3</span>Métadonnées spécifiques</h5>
                    </div>
                    <div class="card-body" id="metadataFields">
                        <!-- Dynamic fields will be inserted here -->
                    </div>
                </div>

                <!-- File Upload -->
                <div class="card step-card mb-4" data-step-content="4" style="display: none;">
                    <div class="card-header step-header">
                        <h5><span class="step-number">4</span>Fichier</h5>
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
                <div class="card step-card mb-4" data-step-content="5" style="display: none;">
                    <div class="card-header step-header">
                        <h5><span class="step-number">5</span>Droits d'accès</h5>
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

                <!-- Navigation Buttons -->
                <div class="d-flex gap-2 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                        <i class="bi bi-arrow-left me-2"></i>Précédent
                    </button>
                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                        <button type="button" class="btn btn-primary btn-lg" id="nextBtn" onclick="changeStep(1)">
                            Suivant<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" style="display: none;">
                            <i class="bi bi-check-circle me-2"></i>Soumettre le document
                        </button>
                    </div>
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
    // Champs pour mémoires et thèses
    'supervisor': { label: 'Directeur/Superviseur', type: 'text', required: true },
    'co_supervisor': { label: 'Co-superviseur', type: 'text', required: false },
    'specialty': { label: 'Spécialité', type: 'text', required: true },
    'defense_date': { label: 'Date de soutenance', type: 'date', required: true },
    'jury': { label: 'Membres du jury (séparez par des virgules)', type: 'textarea', required: true },
    'director': { label: 'Directeur de thèse', type: 'text', required: true },
    'doctoral_school': { label: 'École doctorale', type: 'text', required: true },

    // Champs pour articles scientifiques
    'journal': { label: 'Nom de la revue', type: 'text', required: true },
    'issn': { label: 'ISSN', type: 'text', required: false },
    'doi': { label: 'DOI (Digital Object Identifier)', type: 'text', required: false },
    'volume': { label: 'Volume', type: 'text', required: false },
    'issue': { label: 'Numéro', type: 'text', required: false },
    'pages': { label: 'Pages (ex: 45-67)', type: 'text', required: false },
    'publication_date': { label: 'Date de publication', type: 'date', required: false },
    'publication_status': { label: 'Statut de publication', type: 'select', required: true, options: ['Soumis', 'En révision', 'Accepté', 'Publié'] },

    // Champs pour stages
    'host_institution': { label: 'Structure d\'accueil', type: 'text', required: true },
    'stage_period': { label: 'Période du stage (ex: Jan-Mars 2024)', type: 'text', required: true },
    'stage_supervisor': { label: 'Maître de stage', type: 'text', required: false },

    // Champs pour projets
    'project_type': { label: 'Type de projet', type: 'select', required: true, options: ['Individuel', 'Collectif', 'Recherche', 'Développement'] },
    'partners': { label: 'Partenaires', type: 'text', required: false },

    // Champs pour cours
    'course_level': { label: 'Niveau', type: 'text', required: true },
    'semester': { label: 'Semestre', type: 'select', required: true, options: ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8'] },
    'course_type': { label: 'Type de cours', type: 'select', required: true, options: ['Cours magistral', 'TD', 'TP', 'Support pédagogique'] },
    'credits': { label: 'Nombre de crédits', type: 'number', required: false },

    // Champs pour communications
    'event_name': { label: 'Nom de l\'événement/conférence', type: 'text', required: true },
    'event_date': { label: 'Date de l\'événement', type: 'date', required: true },
    'event_location': { label: 'Lieu de l\'événement', type: 'text', required: true },
    'presentation_type': { label: 'Type de présentation', type: 'select', required: false, options: ['Communication orale', 'Poster', 'Keynote', 'Panel'] },

    // Champs pour rapports institutionnels
    'issuing_body': { label: 'Organe émetteur', type: 'text', required: true },
    'report_period': { label: 'Période couverte', type: 'text', required: true },
    'report_type': { label: 'Type de rapport', type: 'select', required: false, options: ['Annuel', 'Semestriel', 'Trimestriel', 'Ponctuel'] },

    // Champs pour documents administratifs
    'document_type': { label: 'Type de document', type: 'text', required: true },
    'issuing_authority': { label: 'Autorité émettrice', type: 'text', required: true },
    'reference_number': { label: 'Numéro de référence', type: 'text', required: false },

    // Champs pour données de recherche
    'data_type': { label: 'Type de données', type: 'select', required: true, options: ['Quantitatives', 'Qualitatives', 'Mixtes', 'Expérimentales', 'Enquêtes'] },
    'collection_method': { label: 'Méthode de collecte', type: 'text', required: true },
    'data_format': { label: 'Format des données', type: 'text', required: true },
    'sample_size': { label: 'Taille de l\'échantillon', type: 'text', required: false },
    'collection_period': { label: 'Période de collecte', type: 'text', required: false }
};

function updateRequiredFields() {
    const select = document.getElementById('document_type_id');
    const selectedOption = select.options[select.selectedIndex];
    const requiredFields = selectedOption.getAttribute('data-required-fields');

    const metadataCard = document.getElementById('metadataCard');
    const metadataFieldsDiv = document.getElementById('metadataFields');

    if (requiredFields && requiredFields !== 'null') {
        const fields = JSON.parse(requiredFields);

        // Vérifier que le tableau n'est pas vide
        if (fields && fields.length > 0) {
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
            <div class="file-info-alert">
                <i class="bi bi-file-pdf me-2"></i>
                <strong>${file.name}</strong> (${sizeMB} Mo)
            </div>
        `;
    }
}

// Keywords handling with interactive badges
let keywordsArray = [];

function renderKeywordBadges() {
    const badgesContainer = document.getElementById('keywords-badges');
    const inputsContainer = document.getElementById('keywords-inputs');

    // Render badges
    badgesContainer.innerHTML = keywordsArray.map((keyword, index) => `
        <span class="keyword-badge">
            ${keyword}
            <i class="bi bi-x-circle" onclick="removeKeyword(${index})"></i>
        </span>
    `).join('');

    // Create hidden inputs as array
    inputsContainer.innerHTML = keywordsArray.map((keyword, index) => `
        <input type="hidden" name="keywords[${index}]" value="${keyword}">
    `).join('');
}

function removeKeyword(index) {
    keywordsArray.splice(index, 1);
    renderKeywordBadges();
}

function addKeyword(keyword) {
    keyword = keyword.trim();
    if (keyword && !keywordsArray.includes(keyword)) {
        keywordsArray.push(keyword);
        renderKeywordBadges();
    }
}

document.getElementById('keywords_input').addEventListener('keydown', function(e) {
    const value = e.target.value.trim();

    // Add keyword on Enter or comma
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        if (value) {
            addKeyword(value);
            e.target.value = '';
        }
    }
    // Remove last keyword on Backspace if input is empty
    else if (e.key === 'Backspace' && !e.target.value) {
        if (keywordsArray.length > 0) {
            keywordsArray.pop();
            renderKeywordBadges();
        }
    }
});

// Also handle comma typed in input (for paste scenarios)
document.getElementById('keywords_input').addEventListener('input', function(e) {
    const value = e.target.value;
    if (value.includes(',')) {
        const parts = value.split(',');
        parts.slice(0, -1).forEach(part => addKeyword(part));
        e.target.value = parts[parts.length - 1];
    }
});

// Authors management
let authorsArray = [];
let authorIndex = 0;

function addAuthor() {
    const container = document.getElementById('authors-container');
    const index = authorIndex++;

    const authorHtml = `
        <div class="card author-card mb-2" id="author-${index}">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <input type="text"
                               class="form-control form-control-sm"
                               name="authors[${index}][name]"
                               placeholder="Nom complet de l'auteur"
                               required>
                    </div>
                    <div class="col-md-6">
                        <input type="text"
                               class="form-control form-control-sm"
                               name="authors[${index}][institution]"
                               placeholder="Institution / Affiliation">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button"
                                class="btn btn-sm btn-outline-danger"
                                onclick="removeAuthor(${index})"
                                title="Retirer cet auteur">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', authorHtml);
    authorsArray.push(index);
}

function removeAuthor(index) {
    const element = document.getElementById(`author-${index}`);
    if (element) {
        element.remove();
    }
    const arrayIndex = authorsArray.indexOf(index);
    if (arrayIndex > -1) {
        authorsArray.splice(arrayIndex, 1);
    }
}

// Step navigation
let currentStep = 1;
const totalSteps = 5;

function showStep(stepNumber) {
    // Hide all step contents
    document.querySelectorAll('[data-step-content]').forEach(function(el) {
        el.style.display = 'none';
    });

    // Show current step content
    const currentStepEl = document.querySelector(`[data-step-content="${stepNumber}"]`);
    if (currentStepEl) {
        currentStepEl.style.display = 'block';
    }

    // Update progress indicator
    document.querySelectorAll('.progress-step').forEach(function(step, index) {
        if (index < stepNumber) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    // Update buttons visibility
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (stepNumber === 1) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'block';
    }

    // Handle step 3 (metadata) - skip if no metadata required
    if (stepNumber === 3) {
        const metadataCard = document.getElementById('metadataCard');
        const hasMetadata = metadataCard && metadataCard.querySelector('#metadataFields').innerHTML.trim() !== '';

        if (!hasMetadata) {
            // Skip step 3 if no metadata
            if (currentStep < 3) {
                currentStep = 4;
                showStep(4);
                return;
            } else {
                currentStep = 2;
                showStep(2);
                return;
            }
        }
    }

    if (stepNumber === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
    } else {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
    }

    currentStep = stepNumber;
}

function changeStep(direction) {
    let nextStep = currentStep + direction;

    // Skip step 3 if no metadata required
    if (nextStep === 3) {
        const metadataCard = document.getElementById('metadataCard');
        const hasMetadata = metadataCard && metadataCard.querySelector('#metadataFields').innerHTML.trim() !== '';

        if (!hasMetadata) {
            nextStep = direction > 0 ? 4 : 2;
        }
    }

    // Validate before moving forward
    if (direction > 0 && !validateStep(currentStep)) {
        return;
    }

    if (nextStep >= 1 && nextStep <= totalSteps) {
        showStep(nextStep);
    }
}

function validateStep(stepNumber) {
    let isValid = true;
    const currentStepEl = document.querySelector(`[data-step-content="${stepNumber}"]`);

    if (!currentStepEl) return true;

    // Get all required fields in current step
    const requiredFields = currentStepEl.querySelectorAll('[required]');

    requiredFields.forEach(function(field) {
        if (!field.value || field.value === '') {
            isValid = false;
            field.classList.add('is-invalid');

            // Add error message if not exists
            if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = 'Ce champ est obligatoire';
                field.parentNode.insertBefore(errorDiv, field.nextSibling);
            }
        } else {
            field.classList.remove('is-invalid');
            // Remove error message
            const errorDiv = field.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.remove();
            }
        }
    });

    // Special validation for step 2 (authors)
    if (stepNumber === 2) {
        const authorsContainer = document.getElementById('authors-container');
        if (authorsContainer && authorsContainer.children.length === 0) {
            isValid = false;
            alert('Veuillez ajouter au moins un auteur');
        }

        // Keywords validation
        if (keywordsArray.length === 0) {
            isValid = false;
            const keywordsInput = document.getElementById('keywords_input');
            keywordsInput.classList.add('is-invalid');
            if (!document.querySelector('#keywords_input + .invalid-feedback')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.textContent = 'Veuillez ajouter au moins un mot-clé';
                keywordsInput.parentNode.insertBefore(errorDiv, keywordsInput.nextSibling);
            }
        }
    }

    if (!isValid) {
        alert('Veuillez remplir tous les champs obligatoires avant de continuer');
    }

    return isValid;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRequiredFields();
    toggleEmbargoDate();

    // Show first step
    showStep(1);

    // Load existing keywords from old() values (Laravel validation)
    @if(old('keywords'))
        keywordsArray = @json(old('keywords'));
        renderKeywordBadges();
    @endif

    // Add first author by default
    addAuthor();

    // Load existing authors from old() values (Laravel validation)
    @if(old('authors'))
        const oldAuthors = @json(old('authors'));
        // Clear the default author first
        document.getElementById('authors-container').innerHTML = '';
        authorsArray = [];
        authorIndex = 0;

        // Re-add all old authors
        oldAuthors.forEach((author, idx) => {
            addAuthor();
            document.querySelector(`input[name="authors[${idx}][name]"]`).value = author.name || '';
            document.querySelector(`input[name="authors[${idx}][institution]"]`).value = author.institution || '';
        });
    @endif
});
</script>
@endsection
