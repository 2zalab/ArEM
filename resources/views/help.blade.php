@extends('layouts.app')

@section('title', 'Aide - ArEM')

@section('content')
<div class="container px-5 py-5">
    <div class="row">
        <div class="col-lg-3">
            <div class="card sticky-top" style="top: 100px;">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Navigation</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#getting-started">Débuter</a>
                        <a class="nav-link" href="#deposit">Déposer un document</a>
                        <a class="nav-link" href="#search">Rechercher</a>
                        <a class="nav-link" href="#faq">FAQ</a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <h1 class="display-4 fw-bold mb-5">Guide d'utilisation</h1>

            <section id="getting-started" class="mb-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Débuter avec ArEM</h3>
                        <p>ArEM est une plateforme intuitive pour gérer les archives académiques de l'ENS de Maroua.</p>
                        <ol>
                            <li>Créez un compte avec votre adresse email institutionnelle</li>
                            <li>Complétez votre profil avec vos informations académiques</li>
                            <li>Commencez à déposer vos documents ou à consulter les archives</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section id="deposit" class="mb-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Déposer un document</h3>
                        <h5 class="fw-bold mt-4 mb-3">Étapes du dépôt :</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold">Sélectionnez le type</h6>
                                        <p class="small text-muted">Choisissez le type de document approprié</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">2</div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold">Remplissez le formulaire</h6>
                                        <p class="small text-muted">Complétez toutes les métadonnées</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">3</div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold">Téléversez le fichier</h6>
                                        <p class="small text-muted">PDF uniquement, max 20 Mo</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">4</div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold">Validé puis publié</h6>
                                        <p class="small text-muted">Après validation par un modérateur</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="search" class="mb-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Rechercher des documents</h3>
                        <p>ArEM offre plusieurs moyens de recherche :</p>
                        <ul>
                            <li><strong>Recherche simple :</strong> Utilisez la barre de recherche en haut de page</li>
                            <li><strong>Recherche avancée :</strong> Filtrez par auteur, année, type, département</li>
                            <li><strong>Navigation :</strong> Parcourez par catégories (type, département, année)</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section id="faq" class="mb-5">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Questions fréquentes</h3>
                        
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Qui peut déposer des documents ?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Tous les membres de l'ENS de Maroua (étudiants, enseignants, chercheurs) peuvent déposer des documents après création d'un compte.
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
                                        Actuellement, seuls les fichiers PDF sont acceptés, avec une taille maximale de 20 Mo par document.
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
                                        Le délai de validation dépend de la disponibilité des modérateurs, mais nous nous efforçons de traiter les demandes dans les 72 heures.
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
@endsection
