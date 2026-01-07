@extends('layouts.app')

@section('title', 'Modifier le document - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="fw-bold mb-0">Modifier le document</h1>
                    <p class="text-muted mb-0">{{ $document->arem_doc_id }}</p>
                </div>
            </div>

            @if($document->status === 'rejected')
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Document rejeté.</strong> Veuillez apporter les modifications nécessaires avant de soumettre à nouveau.
                </div>
            @endif

            <form action="{{ route('documents.update', $document->arem_doc_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- General Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-1-circle me-2"></i>Informations générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Titre *</label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title', $document->title) }}"
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
                            >{{ old('abstract', $document->abstract) }}</textarea>
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
                                    <option value="fr" {{ old('language', $document->language) == 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ old('language', $document->language) == 'en' ? 'selected' : '' }}>Anglais</option>
                                    <option value="de" {{ old('language', $document->language) == 'de' ? 'selected' : '' }}>Allemand</option>
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
                                    value="{{ old('year', $document->year) }}"
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
                                    value="{{ old('academic_year', $document->academic_year) }}"
                                    placeholder="Ex: 2023-2024"
                                >
                                @error('academic_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-2-circle me-2"></i>Fichier PDF</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Fichier actuel:</strong> {{ $document->file_name }} ({{ round($document->file_size / 1024 / 1024, 2) }} Mo)
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">Remplacer le fichier (optionnel)</label>
                            <input
                                type="file"
                                class="form-control @error('file') is-invalid @enderror"
                                id="file"
                                name="file"
                                accept=".pdf"
                                onchange="displayFileInfo()"
                            >
                            <div class="form-text">Taille maximum : 20 Mo. Laissez vide si vous ne voulez pas remplacer le fichier.</div>
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
                        <h5 class="mb-0"><i class="bi bi-3-circle me-2"></i>Droits d'accès</h5>
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
                                    {{ old('access_rights', $document->access_rights) == 'public' ? 'checked' : '' }}
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
                                    {{ old('access_rights', $document->access_rights) == 'restricted' ? 'checked' : '' }}
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
                                    {{ old('access_rights', $document->access_rights) == 'embargo' ? 'checked' : '' }}
                                    onchange="toggleEmbargoDate()"
                                >
                                <label class="form-check-label" for="access_embargo">
                                    <strong>Embargo</strong> - Accès différé jusqu'à une date
                                </label>
                            </div>
                        </div>

                        <div id="embargoDateField" style="display: {{ old('access_rights', $document->access_rights) == 'embargo' ? 'block' : 'none' }};">
                            <label for="embargo_date" class="form-label fw-bold">Date de levée d'embargo</label>
                            <input
                                type="date"
                                class="form-control @error('embargo_date') is-invalid @enderror"
                                id="embargo_date"
                                name="embargo_date"
                                value="{{ old('embargo_date', $document->embargo_date ? $document->embargo_date->format('Y-m-d') : '') }}"
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
                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
            <div class="alert alert-success">
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
        <span class="badge bg-secondary me-2 mb-2" style="font-size: 0.95rem; padding: 0.5rem 0.75rem;">
            ${keyword}
            <i class="bi bi-x-circle ms-1" style="cursor: pointer;" onclick="removeKeyword(${index})"></i>
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

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleEmbargoDate();

    // Load existing keywords from old() or document data
    @if(old('keywords'))
        keywordsArray = @json(old('keywords'));
    @elseif(isset($document->keywords))
        keywordsArray = @json($document->keywords ?? []);
    @endif

    if (keywordsArray.length > 0) {
        renderKeywordBadges();
    }

    // Add change listener to all access_rights radio buttons
    document.querySelectorAll('input[name="access_rights"]').forEach(radio => {
        radio.addEventListener('change', toggleEmbargoDate);
    });
});
</script>
@endsection
