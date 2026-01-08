@extends('layouts.app')

@section('title', 'Contact - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="display-5 fw-bold mb-2">Contactez-nous</h1>
            <p class="text-muted mb-4">Notre équipe est à votre écoute pour répondre à toutes vos questions</p>

            <!-- Contact Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body p-4">
                            <i class="bi bi-geo-alt-fill text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold mb-3">Notre Adresse</h5>
                            <p class="text-muted mb-2">École Normale Supérieure</p>
                            <p class="text-muted mb-0">BP 55, Maroua, Cameroun</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body p-4">
                            <i class="bi bi-envelope-fill text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold mb-3">Email</h5>
                            <p class="text-muted mb-2">Support technique</p>
                            <a href="mailto:contact@ens-maroua.cm" class="text-decoration-none">
                                contact@ens-maroua.cm
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body p-4">
                            <i class="bi bi-telephone-fill text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold mb-3">Téléphone</h5>
                            <p class="text-muted mb-2">Du lundi au vendredi</p>
                            <p class="mb-0">+237 XXX XXX XXX</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Envoyez-nous un message</h4>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais</p>

                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person me-2"></i>Nom complet *
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               id="name"
                                               placeholder="Votre nom complet"
                                               required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-2"></i>Email *
                                        </label>
                                        <input type="email"
                                               class="form-control"
                                               id="email"
                                               placeholder="votre@email.com"
                                               required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone me-2"></i>Téléphone
                                        </label>
                                        <input type="tel"
                                               class="form-control"
                                               id="phone"
                                               placeholder="+237 XXX XXX XXX">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="subject" class="form-label">
                                            <i class="bi bi-tag me-2"></i>Sujet *
                                        </label>
                                        <select class="form-select" id="subject" required>
                                            <option value="">Choisissez un sujet</option>
                                            <option value="support">Support technique</option>
                                            <option value="question">Question générale</option>
                                            <option value="depot">Aide au dépôt de document</option>
                                            <option value="acces">Problème d'accès</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="message" class="form-label">
                                            <i class="bi bi-chat-text me-2"></i>Message *
                                        </label>
                                        <textarea class="form-control"
                                                  id="message"
                                                  rows="6"
                                                  placeholder="Décrivez votre demande en détail..."
                                                  required></textarea>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-send-fill me-2"></i>Envoyer le message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="col-lg-5">
                    <!-- Quick Info -->
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-info-circle text-primary me-2"></i>Informations utiles
                            </h5>

                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock text-primary fs-4 me-3"></i>
                                    <div>
                                        <strong>Horaires d'ouverture</strong>
                                        <p class="mb-0 text-muted small">Lun-Ven : 8h00 - 17h00</p>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-reply text-primary fs-4 me-3"></i>
                                    <div>
                                        <strong>Temps de réponse</strong>
                                        <p class="mb-0 text-muted small">24-48 heures ouvrables</p>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-headset text-primary fs-4 me-3"></i>
                                    <div>
                                        <strong>Support technique</strong>
                                        <p class="mb-0 text-muted small">Assistance pour les dépôts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Preview -->
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-question-circle text-primary me-2"></i>Questions fréquentes
                            </h5>

                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            Comment déposer un document ?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Créez un compte, connectez-vous, puis cliquez sur "Déposer" dans le menu. Remplissez le formulaire et téléchargez votre document PDF.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Combien de temps pour la validation ?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            La validation prend généralement 3 à 5 jours ouvrables. Vous serez notifié par email du statut de votre document.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            Qui peut déposer des documents ?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Tous les membres de la communauté ENS (étudiants, enseignants, chercheurs) peuvent déposer des documents après inscription.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('help') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-arrow-right me-2"></i>Voir toute l'aide
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
