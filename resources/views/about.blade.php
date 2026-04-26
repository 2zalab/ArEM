@extends('layouts.app')

@section('title', 'À propos - ArEM')

@section('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #0040A0 0%, #1a6ec4 50%, #5AC8FA 100%);
        padding: 80px 0 100px;
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    .about-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }

    .wave-divider {
        width: 100%;
        overflow: hidden;
        line-height: 0;
        margin-top: -2px;
    }

    .wave-divider svg {
        display: block;
    }

    .section-eyebrow {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #5AC8FA;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a2a4a;
        margin-bottom: 0.75rem;
        line-height: 1.2;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1.05rem;
        max-width: 560px;
    }

    /* Mission block */
    .mission-block {
        background: linear-gradient(135deg, rgba(0,64,160,0.04) 0%, rgba(90,200,250,0.06) 100%);
        border-left: 4px solid #0040A0;
        border-radius: 0 12px 12px 0;
        padding: 2rem 2.5rem;
    }

    /* Objective cards */
    .objective-card {
        background: white;
        border-radius: 16px;
        padding: 2rem 1.75rem;
        height: 100%;
        border: 1px solid rgba(0,64,160,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .objective-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0040A0, #5AC8FA);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .objective-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,64,160,0.12);
        border-color: transparent;
    }

    .objective-card:hover::before {
        transform: scaleX(1);
    }

    .objective-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .objective-icon i {
        font-size: 1.5rem;
        color: white;
    }

    /* Document type pills */
    .doc-category {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        height: 100%;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .doc-category:hover {
        box-shadow: 0 8px 24px rgba(0,64,160,0.1);
        border-color: rgba(0,64,160,0.15);
    }

    .doc-category-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }

    .doc-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
        color: #495057;
        font-size: 0.92rem;
    }

    .doc-item i {
        color: #0040A0;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    /* Stat cards */
    .stat-about-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        text-align: center;
        border: 1px solid rgba(0,64,160,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-about-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0040A0, #5AC8FA);
    }

    .stat-about-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0,64,160,0.12);
    }

    .stat-about-card .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(0,64,160,0.08), rgba(90,200,250,0.12));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
    }

    .stat-about-card .stat-icon i {
        font-size: 1.6rem;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Process steps */
    .process-step {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1.5rem;
        border-radius: 12px;
        background: white;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .process-step:hover {
        border-color: rgba(0,64,160,0.2);
        box-shadow: 0 4px 16px rgba(0,64,160,0.08);
    }

    .process-number {
        min-width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0040A0, #5AC8FA);
        color: white;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* CTA section */
    .cta-section {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border-radius: 24px;
        padding: 4rem 3rem;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        pointer-events: none;
    }

    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .btn-cta-white {
        background: white;
        color: #0040A0;
        font-weight: 700;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: none;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cta-white:hover {
        background: #f0f6ff;
        color: #0040A0;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .btn-cta-outline {
        background: transparent;
        color: white;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,0.6);
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cta-outline:hover {
        background: rgba(255,255,255,0.15);
        border-color: white;
        color: white;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')

<!-- Hero -->
<div class="about-hero">
    <div class="container-fluid px-5 position-relative" style="z-index: 1;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="hero-badge">
                    <i class="bi bi-archive me-1"></i>Archives ENS Maroua
                </div>
                <h1 class="display-4 fw-bold text-white mb-3" style="letter-spacing: -0.5px;">
                    À propos d'<span style="color: #a8dff7;">ArEM</span>
                </h1>
                <p class="lead text-white mb-0" style="opacity: 0.88; max-width: 620px; margin: 0 auto;">
                    La plateforme institutionnelle de gestion et de diffusion des travaux académiques
                    de l'École Normale Supérieure de Maroua
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Wave divider -->
<div class="wave-divider" style="background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z" fill="#f8f9fa"/>
    </svg>
</div>

<div style="background: #f8f9fa;">
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">

            <!-- Mission -->
            <div class="row align-items-center g-5 mb-6 py-4" style="margin-bottom: 4rem;">
                <div class="col-lg-5">
                    <p class="section-eyebrow">Notre identité</p>
                    <h2 class="section-title">Une archive au service de la connaissance académique</h2>
                    <p class="section-subtitle mb-0">
                        Adapté au contexte local, ArEM offre une solution simple, pédagogique et efficace
                        pour préserver et valoriser la connaissance produite au sein de l'institution.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="mission-block">
                        <p class="fs-5 mb-3" style="color: #1a2a4a; line-height: 1.8;">
                            <strong>ArEM</strong> — <em>Archives de l'École Normale Supérieure de Maroua</em> — est un dépôt
                            institutionnel numérique conçu pour archiver, gérer et diffuser les productions
                            académiques de l'ENS de Maroua.
                        </p>
                        <p class="mb-0 text-muted">
                            Chaque document déposé reçoit un identifiant pérenne unique (ArEM-ID), une citation
                            générée automatiquement, et est conservé de façon sécurisée pour les générations futures.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Objectives -->
            <div class="mb-5" style="margin-bottom: 4rem;">
                <div class="text-center mb-5">
                    <p class="section-eyebrow">Ce que nous faisons</p>
                    <h2 class="section-title mx-auto">Quatre missions essentielles</h2>
                    <p class="section-subtitle mx-auto text-center">
                        ArEM s'engage à couvrir l'intégralité du cycle de vie d'un document académique
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="objective-card shadow-sm">
                            <div class="objective-icon">
                                <i class="bi bi-upload"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Déposer</h5>
                            <p class="text-muted mb-0 small">
                                Permettre aux chercheurs, enseignants et étudiants de soumettre leurs travaux
                                avec des métadonnées complètes et standardisées.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="objective-card shadow-sm">
                            <div class="objective-icon">
                                <i class="bi bi-patch-check"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Valider</h5>
                            <p class="text-muted mb-0 small">
                                Garantir la qualité et l'authenticité via un workflow de validation
                                académique rigoureux et transparent.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="objective-card shadow-sm">
                            <div class="objective-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Conserver</h5>
                            <p class="text-muted mb-0 small">
                                Préserver à long terme les documents dans un stockage sécurisé
                                avec identifiants pérennes (ArEM-ID).
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="objective-card shadow-sm">
                            <div class="objective-icon">
                                <i class="bi bi-globe2"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Diffuser</h5>
                            <p class="text-muted mb-0 small">
                                Rendre accessible la production scientifique avec des niveaux d'accès
                                adaptés (public, restreint, embargo).
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document types -->
            <div class="mb-5" style="margin-bottom: 4rem;">
                <div class="text-center mb-5">
                    <p class="section-eyebrow">Catalogue</p>
                    <h2 class="section-title mx-auto">Documents acceptés</h2>
                    <p class="section-subtitle mx-auto text-center">
                        ArEM héberge une grande variété de productions académiques et scientifiques
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="doc-category shadow-sm">
                            <div class="doc-category-icon" style="background: rgba(0,64,160,0.08);">
                                <span style="font-size:1.5rem;">🎓</span>
                            </div>
                            <h6 class="fw-bold mb-3" style="color: #0040A0;">Mémoires & Thèses</h6>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Mémoires de Licence</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Mémoires de Master</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Mémoires de DIPES II</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Thèses de Doctorat</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="doc-category shadow-sm">
                            <div class="doc-category-icon" style="background: rgba(90,200,250,0.12);">
                                <span style="font-size:1.5rem;">📄</span>
                            </div>
                            <h6 class="fw-bold mb-3" style="color: #0040A0;">Publications</h6>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Articles scientifiques</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Communications de conférences</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Articles de blog académique</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Données de recherche</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="doc-category shadow-sm">
                            <div class="doc-category-icon" style="background: rgba(25,135,84,0.08);">
                                <span style="font-size:1.5rem;">📁</span>
                            </div>
                            <h6 class="fw-bold mb-3" style="color: #0040A0;">Autres Documents</h6>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Rapports de stage</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Supports pédagogiques</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Projets académiques</div>
                            <div class="doc-item"><i class="bi bi-circle-fill"></i>Rapports institutionnels</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="mb-5" style="margin-bottom: 4rem;">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-about-card shadow-sm">
                            <div class="stat-icon">
                                <i class="bi bi-infinity"></i>
                            </div>
                            <h6 class="fw-bold mb-1" style="color: #1a2a4a;">Stockage évolutif</h6>
                            <p class="text-muted mb-0 small">Capacité non limitée</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-about-card shadow-sm">
                            <div class="stat-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h6 class="fw-bold mb-1" style="color: #1a2a4a;">Sécurité</h6>
                            <p class="text-muted mb-0 small">Accès contrôlés et chiffrés</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-about-card shadow-sm">
                            <div class="stat-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h6 class="fw-bold mb-1" style="color: #1a2a4a;">Conservation pérenne</h6>
                            <p class="text-muted mb-0 small">Archivage à long terme</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-about-card shadow-sm">
                            <div class="stat-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h6 class="fw-bold mb-1" style="color: #1a2a4a;">Recherche avancée</h6>
                            <p class="text-muted mb-0 small">Filtres et recherche plein-texte</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How it works -->
            <div class="mb-5" style="margin-bottom: 4rem;">
                <div class="text-center mb-5">
                    <p class="section-eyebrow">Processus</p>
                    <h2 class="section-title mx-auto">Comment ça fonctionne ?</h2>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="process-step">
                            <div class="process-number">1</div>
                            <div>
                                <h6 class="fw-bold mb-1">Créez un compte</h6>
                                <p class="text-muted mb-0 small">Inscrivez-vous avec votre adresse institutionnelle ENS Maroua.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="process-step">
                            <div class="process-number">2</div>
                            <div>
                                <h6 class="fw-bold mb-1">Déposez votre document</h6>
                                <p class="text-muted mb-0 small">Remplissez le formulaire guidé et téléversez votre PDF.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="process-step">
                            <div class="process-number">3</div>
                            <div>
                                <h6 class="fw-bold mb-1">Validation académique</h6>
                                <p class="text-muted mb-0 small">Un modérateur examine et valide votre soumission.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="process-step">
                            <div class="process-number">4</div>
                            <div>
                                <h6 class="fw-bold mb-1">Publication & diffusion</h6>
                                <p class="text-muted mb-0 small">Votre document est publié et accessible via son ArEM-ID.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="cta-section mb-2">
                <div class="row align-items-center justify-content-between position-relative" style="z-index:1;">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h2 class="fw-bold text-white mb-2" style="font-size: 1.9rem;">
                            Prêt à contribuer aux archives ?
                        </h2>
                        <p class="mb-0" style="color: rgba(255,255,255,0.85); font-size: 1.05rem;">
                            Rejoignez la communauté ArEM et valorisez vos travaux académiques auprès de toute l'institution.
                        </p>
                    </div>
                    <div class="col-lg-auto">
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('documents.create') }}" class="btn-cta-white">
                                <i class="bi bi-upload"></i>Déposer un document
                            </a>
                            <a href="{{ route('documents.index') }}" class="btn-cta-outline">
                                <i class="bi bi-collection"></i>Explorer les archives
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection
