@extends('layouts.app')

@section('title', 'À propos - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="display-5 fw-bold mb-2">À propos d'ArEM</h1>
            <p class="text-muted mb-4">La plateforme institutionnelle de gestion et de diffusion des travaux académiques de l'ENS Maroua</p>

            <!-- Mission -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3"><i class="bi bi-bullseye text-primary me-2"></i>Notre Mission</h3>
                    <p class="lead mb-3">
                        <strong>ArEM</strong> (Archives de l'École Normale Supérieure de Maroua) est un dépôt institutionnel numérique
                        conçu pour archiver, gérer et diffuser les productions académiques de l'ENS de Maroua.
                    </p>
                    <p class="mb-0">
                        Adapté au contexte local, ArEM offre une solution simple, pédagogique et efficace
                        pour préserver et valoriser la connaissance académique produite au sein de notre institution.
                    </p>
                </div>
            </div>

            <!-- Objectifs -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Nos Objectifs</h3>
                    <p class="text-muted mb-4">ArEM s'engage à remplir quatre missions essentielles</p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-upload text-primary fs-4 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Déposer</h5>
                                    <p class="mb-0 text-muted">
                                        Permettre aux chercheurs, enseignants et étudiants de déposer leurs travaux
                                        académiques avec des métadonnées complètes et standardisées.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check2-circle text-primary fs-4 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Valider</h5>
                                    <p class="mb-0 text-muted">
                                        Assurer la qualité et l'authenticité des documents à travers un workflow
                                        de validation académique rigoureux et transparent.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-shield-check text-primary fs-4 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Conserver</h5>
                                    <p class="mb-0 text-muted">
                                        Garantir la préservation à long terme des documents dans un stockage sécurisé
                                        avec attribution d'identifiants pérennes (ArEM-ID).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-globe text-primary fs-4 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-2">Diffuser</h5>
                                    <p class="mb-0 text-muted">
                                        Rendre accessible la production scientifique avec différents niveaux d'accès
                                        (public, restreint, embargo) selon les besoins.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Types de documents -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Types de Documents Acceptés</h3>
                    <p class="text-muted mb-4">ArEM héberge une grande variété de productions académiques</p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-text text-primary me-2"></i>Mémoires & Thèses</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 text-success me-2"></i>Mémoires de Licence</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Mémoires de Master</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Mémoires de DIPES II</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Thèses de Doctorat</li>
                            </ul>
                        </div>

                        <div class="col-md-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-journal-text text-primary me-2"></i>Publications</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 text-success me-2"></i>Articles scientifiques</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Communications</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Articles de blog</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Ouvrages</li>
                            </ul>
                        </div>

                        <div class="col-md-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-briefcase text-primary me-2"></i>Autres Documents</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check2 text-success me-2"></i>Rapports de stage</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Supports pédagogiques</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Projets académiques</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Rapports de recherche</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="card bg-primary text-white mb-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <i class="bi bi-infinity display-4 mb-2"></i>
                            <p class="mb-0">Capacité de stockage évolutive</p>
                        </div>
                        <div class="col-md-3">
                            <i class="bi bi-shield-check display-4 mb-2"></i>
                            <p class="mb-0">Sécurité et confidentialité</p>
                        </div>
                        <div class="col-md-3">
                            <i class="bi bi-clock-history display-4 mb-2"></i>
                            <p class="mb-0">Conservation pérenne</p>
                        </div>
                        <div class="col-md-3">
                            <i class="bi bi-search display-4 mb-2"></i>
                            <p class="mb-0">Recherche avancée</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="card">
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold mb-3">Rejoignez ArEM</h3>
                    <p class="lead mb-4">
                        Participez à la valorisation de la production académique de l'ENS Maroua
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('documents.create') }}" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Déposer un document
                        </a>
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-search me-2"></i>Explorer les archives
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
