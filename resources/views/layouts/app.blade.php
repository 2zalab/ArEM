<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArEM - Archives ENS Maroua')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #003366;
            --secondary-color: #0099cc;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--secondary-color) !important;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        footer {
            background: linear-gradient(135deg, var(--primary-color), #004080);
            color: white;
            margin-top: 80px;
        }

        footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-5">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-archive"></i> ArEM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('documents.index') }}">Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('documents.browse') }}">Parcourir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('help') }}">Aide</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container-fluid px-5 mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container-fluid px-5 mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-5">
        <div class="container-fluid px-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-archive me-2"></i>ArEM
                    </h5>
                    <p class="text-white-50">
                        Plateforme d'Archives de l'École Normale Supérieure de Maroua.
                        Préserver et diffuser la connaissance académique.
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}">À propos d'ArEM</a></li>
                        <li class="mb-2"><a href="{{ route('help') }}">Guide d'utilisation</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Nous contacter</a></li>
                        <li class="mb-2"><a href="{{ route('documents.index') }}">Consulter les archives</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Contact</h5>
                    <p class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>École Normale Supérieure de Maroua<br>
                        <span class="ms-4">Maroua, Cameroun</span>
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i>contact@ens-maroua.cm
                    </p>
                    <p>
                        <i class="bi bi-telephone me-2"></i>+237 XXX XXX XXX
                    </p>
                </div>
            </div>
            <hr class="my-4 bg-white opacity-25">
            <div class="text-center text-white-50">
                <p class="mb-0">&copy; 2026 ArEM - École Normale Supérieure de Maroua. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
