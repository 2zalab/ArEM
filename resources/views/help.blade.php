@extends('layouts.app')

@section('title', 'Aide - ArEM')

@section('styles')
<style>
    .help-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 56px 0 72px;
        position: relative;
        overflow: hidden;
    }

    .help-hero::after {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .wave-sm {
        width: 100%;
        overflow: hidden;
        line-height: 0;
        margin-top: -2px;
    }

    /* Sidebar nav */
    .help-nav {
        position: sticky;
        top: 100px;
    }

    .help-nav .nav-link {
        color: #495057;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        font-size: 0.92rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }

    .help-nav .nav-link:hover {
        background: rgba(0,64,160,0.06);
        color: #0040A0;
    }

    .help-nav .nav-link.active {
        background: linear-gradient(135deg, rgba(0,64,160,0.1), rgba(90,200,250,0.12));
        color: #0040A0;
        font-weight: 600;
    }

    .help-nav .nav-link i {
        font-size: 1rem;
        width: 20px;
        text-align: center;
        color: #5AC8FA;
    }

    /* Section headers */
    .section-anchor {
        scroll-margin-top: 100px;
    }

    .help-section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a2a4a;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .help-section-title i {
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.3rem;
    }

    /* Step items */
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 12px;
        background: #f8f9fa;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .step-item:hover {
        background: white;
        border-color: rgba(0,64,160,0.12);
        box-shadow: 0 4px 12px rgba(0,64,160,0.08);
    }

    .step-num {
        min-width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        color: white;
        font-weight: 800;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Feature list */
    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .feature-item:last-child {
        border-bottom: none;
    }

    .feature-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(0,64,160,0.1), rgba(90,200,250,0.12));
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-icon i {
        color: #0040A0;
        font-size: 0.95rem;
    }

    /* FAQ accordion */
    .faq-accordion .accordion-item {
        border: 1px solid #e9ecef;
        border-radius: 10px !important;
        margin-bottom: 0.75rem;
        overflow: hidden;
    }

    .faq-accordion .accordion-button {
        font-weight: 600;
        color: #1a2a4a;
        background: white;
        border-radius: 10px !important;
        box-shadow: none;
    }

    .faq-accordion .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, rgba(0,64,160,0.05), rgba(90,200,250,0.06));
        color: #0040A0;
        box-shadow: none;
    }

    .faq-accordion .accordion-button::after {
        filter: none;
    }

    .faq-accordion .accordion-button:not(.collapsed)::after {
        filter: hue-rotate(200deg);
    }

    .faq-accordion .accordion-body {
        color: #495057;
        line-height: 1.7;
        background: white;
    }

    /* Info card */
    .info-card {
        background: linear-gradient(135deg, rgba(0,64,160,0.04), rgba(90,200,250,0.06));
        border: 1px solid rgba(0,64,160,0.1);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
    }

    .info-card i {
        color: #0040A0;
    }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="help-hero">
    <div class="container-fluid px-5 position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge mb-3" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:white;font-size:.8rem;letter-spacing:1px;padding:6px 14px;border-radius:50px;">
                    <i class="bi bi-question-circle me-1"></i>Documentation
                </span>
                <h1 class="display-5 fw-bold text-white mb-2">Guide d'utilisation</h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.85);font-size:1.1rem;">
                    Tout ce qu'il faut savoir pour utiliser ArEM — de la création de compte à la publication de vos travaux.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="wave-sm" style="background:linear-gradient(135deg,#0040A0,#5AC8FA);">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,50 L0,50 Z" fill="#f8f9fa"/>
    </svg>
</div>

<div style="background:#f8f9fa;min-height:60vh;">
<div class="container-fluid px-5 py-5">
    <div class="row g-5">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="help-nav card border-0 shadow-sm p-3">
                <p class="text-muted small fw-semibold text-uppercase mb-3" style="letter-spacing:1px;">Sur cette page</p>
                <nav class="nav flex-column gap-1">
                    <a class="nav-link active" href="#getting-started">
                        <i class="bi bi-rocket-takeoff"></i>Débuter
                    </a>
                    <a class="nav-link" href="#deposit">
                        <i class="bi bi-upload"></i>Déposer un document
                    </a>
                    <a class="nav-link" href="#search">
                        <i class="bi bi-search"></i>Rechercher
                    </a>
                    <a class="nav-link" href="#faq">
                        <i class="bi bi-chat-square-dots"></i>FAQ
                    </a>
                </nav>
                <hr>
                <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-upload me-2"></i>Déposer un document
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">

            <!-- Débuter -->
            <section id="getting-started" class="section-anchor mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="help-section-title mb-4">
                            <i class="bi bi-rocket-takeoff"></i>Débuter avec ArEM
                        </h2>
                        <p class="text-muted mb-4">
                            ArEM est une plateforme intuitive pour gérer les archives académiques de l'ENS de Maroua.
                            Suivez ces trois étapes pour commencer.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="step-item h-100">
                                    <div class="step-num">1</div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Créez un compte</h6>
                                        <p class="small text-muted mb-0">Utilisez votre adresse email institutionnelle de l'ENS Maroua.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="step-item h-100">
                                    <div class="step-num">2</div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Complétez votre profil</h6>
                                        <p class="small text-muted mb-0">Renseignez vos informations académiques et votre domaine.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="step-item h-100">
                                    <div class="step-num">3</div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Explorez ou déposez</h6>
                                        <p class="small text-muted mb-0">Consultez les archives ou soumettez vos propres travaux.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Déposer -->
            <section id="deposit" class="section-anchor mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="help-section-title mb-1">
                            <i class="bi bi-upload"></i>Déposer un document
                        </h2>
                        <p class="text-muted mb-4">Le formulaire de dépôt est structuré en étapes progressives.</p>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="step-item">
                                <div class="step-num">1</div>
                                <div>
                                    <h6 class="fw-bold mb-1">Sélectionnez le type de document</h6>
                                    <p class="small text-muted mb-0">Choisissez parmi mémoire, article, rapport, thèse… Le formulaire s'adapte automatiquement.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-num">2</div>
                                <div>
                                    <h6 class="fw-bold mb-1">Renseignez les métadonnées spécifiques</h6>
                                    <p class="small text-muted mb-0">Directeur, jury, revue, événement… selon le type choisi.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-num">3</div>
                                <div>
                                    <h6 class="fw-bold mb-1">Complétez les informations générales</h6>
                                    <p class="small text-muted mb-0">Titre, auteurs, résumé, mots-clés, langue et année.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-num">4</div>
                                <div>
                                    <h6 class="fw-bold mb-1">Téléversez le fichier PDF</h6>
                                    <p class="small text-muted mb-0">Format PDF uniquement, taille maximale 20 Mo.</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-num">5</div>
                                <div>
                                    <h6 class="fw-bold mb-1">Définissez les droits d'accès</h6>
                                    <p class="small text-muted mb-0">Public, restreint aux membres, ou sous embargo jusqu'à une date.</p>
                                </div>
                            </div>
                        </div>

                        <div class="info-card">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Après soumission</strong> — Votre document reçoit un identifiant ArEM-ID unique et passe en attente de validation par un modérateur.
                        </div>
                    </div>
                </div>
            </section>

            <!-- Rechercher -->
            <section id="search" class="section-anchor mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="help-section-title mb-1">
                            <i class="bi bi-search"></i>Rechercher des documents
                        </h2>
                        <p class="text-muted mb-4">ArEM offre plusieurs modes de recherche pour trouver rapidement ce que vous cherchez.</p>

                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-search"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Recherche simple</h6>
                                <p class="small text-muted mb-0">Utilisez la barre de recherche en haut de page — elle interroge les titres, résumés et mots-clés.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-sliders"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Recherche avancée</h6>
                                <p class="small text-muted mb-0">Filtrez par auteur, plage d'années, type de document, domaine ou langue.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-grid"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Navigation par catégories</h6>
                                <p class="small text-muted mb-0">Parcourez les archives groupées par type de document, domaine ou année de publication.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-layout-list"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Vue liste ou grille</h6>
                                <p class="small text-muted mb-0">Sur la page Documents, basculez entre une vue liste détaillée et une vue grille compacte.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section id="faq" class="section-anchor">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="help-section-title mb-4">
                            <i class="bi bi-chat-square-dots"></i>Questions fréquentes
                        </h2>

                        <div class="accordion faq-accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Qui peut déposer des documents ?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Tous les membres de l'ENS de Maroua (étudiants, enseignants, chercheurs) peuvent déposer des documents après création d'un compte et vérification de leur adresse email.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Quels formats de fichiers sont acceptés ?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Actuellement seuls les fichiers <strong>PDF</strong> sont acceptés, avec une taille maximale de <strong>20 Mo</strong> par document.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Combien de temps prend la validation ?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Le délai dépend de la disponibilité des modérateurs. Nous nous efforçons de traiter les demandes dans les <strong>72 heures</strong> ouvrables. Vous recevez une notification dès la décision prise.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Puis-je modifier un document après soumission ?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Oui, tant que le document n'est pas encore publié. Une fois publié, il n'est plus modifiable pour garantir l'intégrité des archives.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                        Qu'est-ce que l'ArEM-ID ?
                                    </button>
                                </h2>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        L'ArEM-ID est un identifiant pérenne unique attribué automatiquement à chaque document (ex : <code>AREM-DOC-ENS-2026-00001</code>). Il permet de citer et retrouver le document de façon stable, même si son URL venait à changer.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')
<script>
// Highlight active nav link on scroll
const sections = document.querySelectorAll('.section-anchor');
const navLinks = document.querySelectorAll('.help-nav .nav-link');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            navLinks.forEach(link => link.classList.remove('active'));
            const active = document.querySelector(`.help-nav .nav-link[href="#${entry.target.id}"]`);
            if (active) active.classList.add('active');
        }
    });
}, { rootMargin: '-20% 0px -70% 0px' });

sections.forEach(s => observer.observe(s));
</script>
@endsection
