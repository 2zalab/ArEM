<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ArEM') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0040A0;
            --secondary-color: #5AC8FA;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left side - Image with blur effect */
        .auth-left {
            flex: 1;
            position: relative;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            background-image:
                linear-gradient(135deg, rgba(0, 51, 102, 0.9) 0%, rgba(0, 153, 204, 0) 100%),
                url('/images/univ-maroua.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 60px;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            backdrop-filter: blur(3px);
        }

        .auth-left-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        .auth-left h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .auth-left p {
            font-size: 1.2rem;
            opacity: 0.95;
            line-height: 1.8;
        }

        .auth-left .logo {
            margin-bottom: 32px;
        }

        .auth-left .logo img {
            max-width: 150px;
        }

        /* Right side - Form */
        .auth-right {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .auth-form-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-form-header {
            margin-bottom: 32px;
        }

        .auth-form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .auth-form-header p {
            color: #6c757d;
            margin: 0;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 153, 204, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 51, 102, 0.2);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-width: 2px;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-text {
            font-size: 0.875rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--secondary-color);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 16px;
            color: #6c757d;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-left {
                min-height: 300px;
                padding: 40px 20px;
            }

            .auth-left h1 {
                font-size: 2.5rem;
            }

            .auth-left .logo {
                font-size: 3rem;
            }

            .auth-right {
                padding: 40px 20px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-form-container {
            animation: fadeInUp 0.6s ease;
        }

        .auth-left-content {
            animation: fadeInUp 0.8s ease;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Image/Branding -->
        <div class="auth-left">
            <div class="auth-left-content">
                <div class="logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo ArEM">
                </div>
                <!--h1>ArEM</h1-->
                <p class="lead">
                    Archives de l'École Normale Supérieure de Maroua
                </p>
                <p class="mt-4">
                    Plateforme de gestion et de diffusion de la production scientifique et académique de notre institution.
                </p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
                </a>

                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
