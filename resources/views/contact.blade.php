@extends('layouts.app')

@section('title', 'Contact - ArEM')

@section('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        padding: 80px 0;
        margin-bottom: 50px;
    }

    .contact-card {
        border: none;
        border-radius: 15px;
        padding: 40px;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        height: 100%;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .contact-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 25px;
        transition: all 0.3s;
    }

    .contact-card:hover .contact-icon {
        transform: rotate(360deg) scale(1.1);
    }

    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }

    .form-label {
        color: #0040A0;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e3f2fd;
        border-radius: 12px;
        padding: 14px 18px;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #5AC8FA;
        box-shadow: 0 0 0 0.2rem rgba(90, 200, 250, 0.15);
    }

    .btn-send {
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border: none;
        border-radius: 12px;
        padding: 16px 50px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }

    .btn-send:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 64, 160, 0.3);
        color: white;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .info-item:hover {
        background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%);
        transform: translateX(5px);
    }

    .info-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .faq-item {
        background: white;
        border: 2px solid #e3f2fd;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s;
    }

    .faq-item:hover {
        border-color: #5AC8FA;
        box-shadow: 0 5px 20px rgba(90, 200, 250, 0.1);
    }

    .faq-question {
        color: #0040A0;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-answer {
        color: #666;
        margin: 0;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="contact-hero">
    <div class="container-fluid px-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <i class="bi bi-envelope-heart display-1 mb-4"></i>
                <h1 class="display-3 fw-bold mb-4">Contactez-nous</h1>
                <p class="lead fs-4">
                    Notre équipe est à votre écoute pour répondre à toutes vos questions
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Contact Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: #0040A0;">Notre Adresse</h4>
                        <p class="text-muted mb-2">École Normale Supérieure</p>
                        <p class="text-muted mb-0">BP 55, Maroua, Cameroun</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: #0040A0;">Email</h4>
                        <p class="text-muted mb-2">Support technique</p>
                        <a href="mailto:contact@ens-maroua.cm" class="text-decoration-none" style="color: #5AC8FA; font-weight: 600;">
                            contact@ens-maroua.cm
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: #0040A0;">Téléphone</h4>
                        <p class="text-muted mb-2">Du lundi au vendredi</p>
                        <p class="mb-0" style="color: #5AC8FA; font-weight: 600;">+237 XXX XXX XXX</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="form-card">
                        <div class="form-header">
                            <i class="bi bi-chat-dots display-4 mb-3"></i>
                            <h3 class="fw-bold mb-2">Envoyez-nous un message</h3>
                            <p class="mb-0 opacity-90">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais</p>
                        </div>

                        <div class="p-5">
                            <form>
                                <div class="row g-4">
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

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-send btn-lg">
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
                    <div class="card border-0" style="border-radius: 15px; background: linear-gradient(135deg, rgba(0, 64, 160, 0.05) 0%, rgba(90, 200, 250, 0.05) 100%); padding: 30px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
                        <h4 class="fw-bold mb-4" style="color: #0040A0;">
                            <i class="bi bi-info-circle me-2"></i>Informations utiles
                        </h4>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <strong style="color: #0040A0;">Horaires d'ouverture</strong>
                                <p class="mb-0 text-muted small">Lun-Ven : 8h00 - 17h00</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-reply"></i>
                            </div>
                            <div>
                                <strong style="color: #0040A0;">Temps de réponse</strong>
                                <p class="mb-0 text-muted small">24-48 heures ouvrables</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <strong style="color: #0040A0;">Support technique</strong>
                                <p class="mb-0 text-muted small">Assistance pour les dépôts</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Preview -->
                    <div class="card border-0" style="border-radius: 15px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); padding: 30px;">
                        <h4 class="fw-bold mb-4" style="color: #0040A0;">
                            <i class="bi bi-question-circle me-2"></i>Questions fréquentes
                        </h4>

                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-3" style="border-radius: 12px; overflow: hidden;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="background: #f8f9fa; color: #0040A0; font-weight: 600;">
                                        Comment déposer un document ?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Créez un compte, connectez-vous, puis cliquez sur "Déposer" dans le menu. Remplissez le formulaire et téléchargez votre document PDF.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3" style="border-radius: 12px; overflow: hidden;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="background: #f8f9fa; color: #0040A0; font-weight: 600;">
                                        Combien de temps pour la validation ?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        La validation prend généralement 3 à 5 jours ouvrables. Vous serez notifié par email du statut de votre document.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0" style="border-radius: 12px; overflow: hidden;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" style="background: #f8f9fa; color: #0040A0; font-weight: 600;">
                                        Qui peut déposer des documents ?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Tous les membres de la communauté ENS (étudiants, enseignants, chercheurs) peuvent déposer des documents après inscription.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('help') }}" class="btn" style="border: 2px solid #5AC8FA; color: #0040A0; border-radius: 12px; padding: 10px 30px; font-weight: 600;">
                                <i class="bi bi-arrow-right me-2"></i>Voir toute l'aide
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
