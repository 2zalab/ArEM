<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ArEM - Archives ENS Maroua')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #003366; --secondary-color: #0099cc; }
        .navbar-brand { font-weight: bold; color: var(--primary-color) !important; }
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        footer { background-color: var(--primary-color); color: white; margin-top: 50px; }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-archive"></i> ArEM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('documents.index') }}">Documents</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('search.advanced') }}">Recherche</a></li>
                </ul>
                <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Rechercher...">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <footer class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="bi bi-archive"></i> ArEM</h5>
                    <p>Plateforme d'Archives de l'École Normale Supérieure de Maroua</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="text-white">À propos</a></li>
                        <li><a href="{{ route('help') }}" class="text-white">Aide</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>ENS Maroua<br>Email: contact@ens-maroua.cm</p>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center"><p>&copy; 2026 ArEM - ENS Maroua.</p></div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
