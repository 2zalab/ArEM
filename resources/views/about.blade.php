@extends('layouts.app')

@section('title', 'À propos - ArEM')

@section('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 80px 0;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .about-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .mission-card {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        border: none;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        border-left: 5px solid #5AC8FA;
    }

    .feature-card {
        border: none;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        background: white;
        box-shadow: 0 10px 30px rgba(0, 64, 160, 0.08);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #0040A0 0%, #5AC8FA 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s;
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 64, 160, 0.15);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .value-item {
        display: flex;
        align-items: start;
        margin-bottom: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s;
    }

    .value-item:hover {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        transform: translateX(10px);
    }

    .value-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .stats-section {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 60px 0;
        margin: 60px 0;
        border-radius: 30px;
        color: white;
    }

    .stat-item {
        text-align: center;
        padding: 20px;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="about-hero">
    <div class="container-fluid px-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white position-relative" style="z-index: 1;">
                <i class="bi bi-book display-1 mb-4"></i>
                <h1 class="display-3 fw-bold mb-4">À propos d'ArEM</h1>
                <p class="lead fs-4">
                    La plateforme institutionnelle de gestion et de diffusion<br>
                    des travaux académiques de l'ENS Maroua
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Mission -->
            <div class="mission-card">
                <div class="row align-items-center">
                    <div class="col-lg-2 text-center">
                        <i class="bi bi-bullseye display-3" style="color: #0040A0;"></i>
                    </div>
                    <div class="col-lg-10">
                        <h2 class="fw-bold mb-3" style="color: #0040A0;">Notre Mission</h2>
                        <p class="lead mb-3">
                            <strong>ArEM</strong> (Archives de l'École Normale Supérieure de Maroua) est un dépôt institutionnel numérique
                            conçu pour archiver, gérer et diffuser les productions académiques de l'ENS de Maroua.
                        </p>
                        <p class="mb-0">
                            Inspiré de HAL mais adapté au contexte local, ArEM offre une solution simple, pédagogique et efficace
                            pour préserver et valoriser la connaissance académique produite au sein de notre institution.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Objectifs -->
            <div class="mb-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-6" style="color: #0040A0;">Nos Objectifs</h2>
                    <p class="text-muted">ArEM s'engage à remplir quatre missions essentielles</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="value-item">
                            <div class="value-icon">
                                <i class="bi bi-upload"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2" style="color: #0040A0;">Déposer</h5>
                                <p class="mb-0 text-muted">
                                    Permettre aux chercheurs, enseignants et étudiants de déposer leurs travaux
                                    académiques avec des métadonnées complètes et standardisées.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="value-item">
                            <div class="value-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2" style="color: #0040A0;">Valider</h5>
                                <p class="mb-0 text-muted">
                                    Assurer la qualité et l'authenticité des documents à travers un workflow
                                    de validation académique rigoureux et transparent.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="value-item">
                            <div class="value-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2" style="color: #0040A0;">Conserver</h5>
                                <p class="mb-0 text-muted">
                                    Garantir la préservation à long terme des documents dans un stockage sécurisé
                                    avec attribution d'identifiants pérennes (ArEM-ID).
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="value-item">
                            <div class="value-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2" style="color: #0040A0;">Diffuser</h5>
                                <p class="mb-0 text-muted">
                                    Rendre accessible la production scientifique avec différents niveaux d'accès
                                    (public, restreint, embargo) selon les besoins.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Types de documents -->
            <div class="mb-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-6" style="color: #0040A0;">Types de Documents Acceptés</h2>
                    <p class="text-muted">ArEM héberge une grande variété de productions académiques</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #0040A0;">Mémoires & Thèses</h4>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Mémoires de Licence</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Mémoires de Master</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Mémoires de DIPES II</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Thèses de Doctorat</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #0040A0;">Publications</h4>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Articles scientifiques</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Communications</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Articles de blog</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Ouvrages</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #0040A0;">Autres Documents</h4>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Rapports de stage</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Supports pédagogiques</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Projets académiques</li>
                                <li><i class="bi bi-check2 me-2" style="color: #5AC8FA;"></i>Rapports de recherche</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="bi bi-infinity"></i>
                                </div>
                                <div class="stat-label">Capacité de stockage évolutive</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="stat-label">Sécurité et confidentialité</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="stat-label">Conservation pérenne</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">
                                    <i class="bi bi-search"></i>
                                </div>
                                <div class="stat-label">Recherche avancée</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-5">
                <div class="card border-0" style="background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%); border-radius: 20px;">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3" style="color: #0040A0;">Rejoignez ArEM</h3>
                        <p class="lead mb-4">
                            Participez à la valorisation de la production académique de l'ENS Maroua
                        </p>
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('documents.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%); color: white; border-radius: 12px; padding: 14px 40px; font-weight: 600;">
                                <i class="bi bi-upload me-2"></i>Déposer un document
                            </a>
                            <a href="{{ route('documents.index') }}" class="btn btn-lg" style="border: 2px solid #5AC8FA; color: #0040A0; border-radius: 12px; padding: 14px 40px; font-weight: 600;">
                                <i class="bi bi-search me-2"></i>Explorer les archives
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
