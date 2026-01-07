@extends('layouts.app')

@section('title', 'À propos - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="display-4 fw-bold mb-4">À propos d'ArEM</h1>
            
            <div class="card mb-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">Notre Mission</h3>
                    <p class="lead">
                        ArEM (Archives de l'École Normale Supérieure de Maroua) est un dépôt institutionnel numérique conçu pour archiver, gérer et diffuser les productions académiques de l'ENS de Maroua.
                    </p>
                    <p>
                        Inspiré de HAL mais adapté au contexte local, ArEM offre une solution simple, pédagogique et efficace pour préserver et valoriser la connaissance académique produite au sein de notre institution.
                    </p>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3"><i class="bi bi-bullseye text-primary me-2"></i>Objectifs</h4>
                            <ul>
                                <li>Déposer des travaux académiques avec métadonnées complètes</li>
                                <li>Valider selon un workflow académique rigoureux</li>
                                <li>Conserver dans un stockage sécurisé avec identifiants pérennes</li>
                                <li>Diffuser avec un accès public ou contrôlé</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3"><i class="bi bi-file-earmark-text text-primary me-2"></i>Types de documents</h4>
                            <ul>
                                <li>Mémoires de Licence et Master</li>
                                <li>Thèses de Doctorat</li>
                                <li>Articles scientifiques</li>
                                <li>Rapports de stage</li>
                                <li>Supports pédagogiques</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">Technologie</h3>
                    <p>
                        ArEM est développé avec Laravel, un framework PHP moderne et robuste, garantissant performance, sécurité et évolutivité de la plateforme.
                    </p>
                    <p class="mb-0">
                        La plateforme utilise des standards académiques reconnus (Dublin Core, OAI-PMH) pour assurer l'interopérabilité avec d'autres dépôts institutionnels.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
