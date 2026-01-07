@extends('layouts.app')

@section('title', 'Contact - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-4 text-center">Nous contacter</h1>
            <p class="lead text-center mb-5">
                Une question ? Besoin d'aide ? N'hésitez pas à nous contacter.
            </p>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                            <h5 class="fw-bold">Adresse</h5>
                            <p class="text-muted small">
                                École Normale Supérieure<br>
                                Maroua, Cameroun
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-envelope fs-1 text-primary mb-3"></i>
                            <h5 class="fw-bold">Email</h5>
                            <p class="text-muted small">
                                contact@ens-maroua.cm
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-telephone fs-1 text-primary mb-3"></i>
                            <h5 class="fw-bold">Téléphone</h5>
                            <p class="text-muted small">
                                +237 XXX XXX XXX
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Envoyez-nous un message</h4>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-send me-2"></i>Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
