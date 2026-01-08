@extends('layouts.app')

@section('title', 'Mon CV - ArEM')

@section('styles')
<style>
    .section-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .section-header {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .section-body {
        padding: 1.5rem;
    }

    .dynamic-item {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .dynamic-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }

    .btn-add-item {
        border: 2px dashed #0040A0;
        color: #0040A0;
        font-weight: 600;
    }

    .btn-add-item:hover {
        background-color: #0040A0;
        color: white;
        border-style: solid;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold mb-1">Mon CV</h1>
                    <p class="text-muted mb-0">Créez et gérez votre curriculum vitae professionnel</p>
                </div>
                <a href="{{ route('profile.cv.export') }}" class="btn btn-success">
                    <i class="bi bi-file-pdf me-2"></i>Exporter en PDF
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.cv.update') }}" method="POST" id="cvForm">
                @csrf

                <!-- Informations personnelles -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-person me-2"></i>Informations personnelles</h5>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nom complet</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label fw-bold">Date de naissance</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date"
                                       value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_place" class="form-label fw-bold">Lieu de naissance</label>
                                <input type="text" class="form-control" id="birth_place" name="birth_place"
                                       value="{{ old('birth_place', $user->birth_place) }}" placeholder="Ex: Yaoundé, Cameroun">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nationality" class="form-label fw-bold">Nationalité</label>
                                <input type="text" class="form-control" id="nationality" name="nationality"
                                       value="{{ old('nationality', $user->nationality) }}" placeholder="Ex: Camerounaise">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Téléphone</label>
                                <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Adresse</label>
                            <textarea class="form-control" id="address" name="address" rows="2"
                                      placeholder="Votre adresse complète">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="linkedin" class="form-label fw-bold">LinkedIn</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin"
                                       value="{{ old('linkedin', $user->linkedin) }}" placeholder="https://linkedin.com/in/...">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="orcid" class="form-label fw-bold">ORCID</label>
                                <input type="text" class="form-control" id="orcid" name="orcid"
                                       value="{{ old('orcid', $user->orcid) }}" placeholder="0000-0000-0000-0000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="google_scholar" class="form-label fw-bold">Google Scholar</label>
                                <input type="url" class="form-control" id="google_scholar" name="google_scholar"
                                       value="{{ old('google_scholar', $user->google_scholar) }}" placeholder="https://scholar.google.com/...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profil / Bio -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-file-text me-2"></i>Profil</h5>
                    </div>
                    <div class="section-body">
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Présentation professionnelle</label>
                            <textarea class="form-control" id="bio" name="bio" rows="5"
                                      placeholder="Rédigez une brève présentation de votre parcours, vos compétences clés et vos objectifs professionnels (3-5 lignes)">{{ old('bio', $user->bio) }}</textarea>
                            <small class="text-muted">Cette présentation apparaîtra en haut de votre CV</small>
                        </div>
                    </div>
                </div>

                <!-- Formation académique -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-mortarboard me-2"></i>Formation académique</h5>
                    </div>
                    <div class="section-body">
                        <div id="education-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addEducation()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une formation
                        </button>
                    </div>
                </div>

                <!-- Expérience professionnelle -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-briefcase me-2"></i>Expérience professionnelle</h5>
                    </div>
                    <div class="section-body">
                        <div id="experience-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addExperience()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une expérience
                        </button>
                    </div>
                </div>

                <!-- Compétences -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-star me-2"></i>Compétences</h5>
                    </div>
                    <div class="section-body">
                        <div id="skills-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addSkill()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une compétence
                        </button>
                    </div>
                </div>

                <!-- Langues -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-translate me-2"></i>Langues</h5>
                    </div>
                    <div class="section-body">
                        <div id="languages-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addLanguage()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une langue
                        </button>
                    </div>
                </div>

                <!-- Publications -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-journal-text me-2"></i>Publications</h5>
                    </div>
                    <div class="section-body">
                        <div id="publications-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addPublication()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une publication
                        </button>
                    </div>
                </div>

                <!-- Certifications -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-award me-2"></i>Certifications et distinctions</h5>
                    </div>
                    <div class="section-body">
                        <div id="certifications-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addCertification()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une certification
                        </button>
                    </div>
                </div>

                <!-- Références -->
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="bi bi-people me-2"></i>Références</h5>
                    </div>
                    <div class="section-body">
                        <div id="references-container"></div>
                        <button type="button" class="btn btn-add-item w-100" onclick="addReference()">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter une référence
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('profile.documents') }}" class="btn btn-outline-secondary btn-lg">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Enregistrer le CV
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Counters
let educationIndex = 0;
let experienceIndex = 0;
let skillIndex = 0;
let languageIndex = 0;
let publicationIndex = 0;
let certificationIndex = 0;
let referenceIndex = 0;

// Add Education
function addEducation() {
    const container = document.getElementById('education-container');
    const html = `
        <div class="dynamic-item" id="education-${educationIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('education-${educationIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="education[${educationIndex}][degree]" placeholder="Diplôme" required>
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="education[${educationIndex}][institution]" placeholder="Établissement" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="education[${educationIndex}][start_date]" placeholder="Année début">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="education[${educationIndex}][end_date]" placeholder="Année fin">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="education[${educationIndex}][location]" placeholder="Lieu">
                </div>
            </div>
            <textarea class="form-control" name="education[${educationIndex}][description]" rows="2" placeholder="Description"></textarea>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    educationIndex++;
}

// Add Experience
function addExperience() {
    const container = document.getElementById('experience-container');
    const html = `
        <div class="dynamic-item" id="experience-${experienceIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('experience-${experienceIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="experience[${experienceIndex}][position]" placeholder="Poste" required>
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="experience[${experienceIndex}][company]" placeholder="Entreprise/Organisation" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="experience[${experienceIndex}][start_date]" placeholder="Date début">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="experience[${experienceIndex}][end_date]" placeholder="Date fin">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="experience[${experienceIndex}][location]" placeholder="Lieu">
                </div>
            </div>
            <textarea class="form-control" name="experience[${experienceIndex}][description]" rows="2" placeholder="Description des responsabilités"></textarea>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    experienceIndex++;
}

// Add Skill
function addSkill() {
    const container = document.getElementById('skills-container');
    const html = `
        <div class="dynamic-item" id="skill-${skillIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('skill-${skillIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="skills[${skillIndex}][category]" placeholder="Catégorie" required>
                </div>
                <div class="col-md-8 mb-2">
                    <input type="text" class="form-control" name="skills[${skillIndex}][items]" placeholder="Compétences (séparées par des virgules)" required>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    skillIndex++;
}

// Add Language
function addLanguage() {
    const container = document.getElementById('languages-container');
    const html = `
        <div class="dynamic-item" id="language-${languageIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('language-${languageIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="languages[${languageIndex}][language]" placeholder="Langue" required>
                </div>
                <div class="col-md-6 mb-2">
                    <select class="form-select" name="languages[${languageIndex}][level]" required>
                        <option value="">Niveau</option>
                        <option value="Débutant">Débutant</option>
                        <option value="Intermédiaire">Intermédiaire</option>
                        <option value="Avancé">Avancé</option>
                        <option value="Courant">Courant</option>
                        <option value="Langue maternelle">Langue maternelle</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    languageIndex++;
}

// Add Publication
function addPublication() {
    const container = document.getElementById('publications-container');
    const html = `
        <div class="dynamic-item" id="publication-${publicationIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('publication-${publicationIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="mb-2">
                <input type="text" class="form-control" name="publications[${publicationIndex}][title]" placeholder="Titre de la publication" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="publications[${publicationIndex}][authors]" placeholder="Auteurs">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control" name="publications[${publicationIndex}][year]" placeholder="Année">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control" name="publications[${publicationIndex}][type]" placeholder="Type">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-2">
                    <input type="text" class="form-control" name="publications[${publicationIndex}][journal]" placeholder="Revue/Conférence">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="publications[${publicationIndex}][doi]" placeholder="DOI">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    publicationIndex++;
}

// Add Certification
function addCertification() {
    const container = document.getElementById('certifications-container');
    const html = `
        <div class="dynamic-item" id="certification-${certificationIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('certification-${certificationIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-8 mb-2">
                    <input type="text" class="form-control" name="certifications[${certificationIndex}][name]" placeholder="Nom de la certification" required>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" name="certifications[${certificationIndex}][year]" placeholder="Année">
                </div>
            </div>
            <input type="text" class="form-control" name="certifications[${certificationIndex}][issuer]" placeholder="Organisme émetteur">
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    certificationIndex++;
}

// Add Reference
function addReference() {
    const container = document.getElementById('references-container');
    const html = `
        <div class="dynamic-item" id="reference-${referenceIndex}">
            <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeItem('reference-${referenceIndex}')">
                <i class="bi bi-trash"></i>
            </button>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="references[${referenceIndex}][name]" placeholder="Nom complet" required>
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="references[${referenceIndex}][position]" placeholder="Poste" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control" name="references[${referenceIndex}][organization]" placeholder="Organisation">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="email" class="form-control" name="references[${referenceIndex}][email]" placeholder="Email">
                </div>
            </div>
            <input type="tel" class="form-control" name="references[${referenceIndex}][phone]" placeholder="Téléphone">
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    referenceIndex++;
}

// Remove Item
function removeItem(id) {
    document.getElementById(id).remove();
}

// Load existing data
document.addEventListener('DOMContentLoaded', function() {
    // Load education
    const education = @json($user->education ?? []);
    education.forEach(item => {
        addEducation();
        const index = educationIndex - 1;
        document.querySelector(`[name="education[${index}][degree]"]`).value = item.degree || '';
        document.querySelector(`[name="education[${index}][institution]"]`).value = item.institution || '';
        document.querySelector(`[name="education[${index}][start_date]"]`).value = item.start_date || '';
        document.querySelector(`[name="education[${index}][end_date]"]`).value = item.end_date || '';
        document.querySelector(`[name="education[${index}][location]"]`).value = item.location || '';
        document.querySelector(`[name="education[${index}][description]"]`).value = item.description || '';
    });

    // Load experience
    const experience = @json($user->experience ?? []);
    experience.forEach(item => {
        addExperience();
        const index = experienceIndex - 1;
        document.querySelector(`[name="experience[${index}][position]"]`).value = item.position || '';
        document.querySelector(`[name="experience[${index}][company]"]`).value = item.company || '';
        document.querySelector(`[name="experience[${index}][start_date]"]`).value = item.start_date || '';
        document.querySelector(`[name="experience[${index}][end_date]"]`).value = item.end_date || '';
        document.querySelector(`[name="experience[${index}][location]"]`).value = item.location || '';
        document.querySelector(`[name="experience[${index}][description]"]`).value = item.description || '';
    });

    // Load skills
    const skills = @json($user->skills ?? []);
    skills.forEach(item => {
        addSkill();
        const index = skillIndex - 1;
        document.querySelector(`[name="skills[${index}][category]"]`).value = item.category || '';
        document.querySelector(`[name="skills[${index}][items]"]`).value = item.items || '';
    });

    // Load languages
    const languages = @json($user->languages ?? []);
    languages.forEach(item => {
        addLanguage();
        const index = languageIndex - 1;
        document.querySelector(`[name="languages[${index}][language]"]`).value = item.language || '';
        document.querySelector(`[name="languages[${index}][level]"]`).value = item.level || '';
    });

    // Load publications
    const publications = @json($user->publications ?? []);
    publications.forEach(item => {
        addPublication();
        const index = publicationIndex - 1;
        document.querySelector(`[name="publications[${index}][title]"]`).value = item.title || '';
        document.querySelector(`[name="publications[${index}][authors]"]`).value = item.authors || '';
        document.querySelector(`[name="publications[${index}][year]"]`).value = item.year || '';
        document.querySelector(`[name="publications[${index}][type]"]`).value = item.type || '';
        document.querySelector(`[name="publications[${index}][journal]"]`).value = item.journal || '';
        document.querySelector(`[name="publications[${index}][doi]"]`).value = item.doi || '';
    });

    // Load certifications
    const certifications = @json($user->certifications ?? []);
    certifications.forEach(item => {
        addCertification();
        const index = certificationIndex - 1;
        document.querySelector(`[name="certifications[${index}][name]"]`).value = item.name || '';
        document.querySelector(`[name="certifications[${index}][year]"]`).value = item.year || '';
        document.querySelector(`[name="certifications[${index}][issuer]"]`).value = item.issuer || '';
    });

    // Load references
    const references = @json($user->references ?? []);
    references.forEach(item => {
        addReference();
        const index = referenceIndex - 1;
        document.querySelector(`[name="references[${index}][name]"]`).value = item.name || '';
        document.querySelector(`[name="references[${index}][position]"]`).value = item.position || '';
        document.querySelector(`[name="references[${index}][organization]"]`).value = item.organization || '';
        document.querySelector(`[name="references[${index}][email]"]`).value = item.email || '';
        document.querySelector(`[name="references[${index}][phone]"]`).value = item.phone || '';
    });
});
</script>
@endsection
