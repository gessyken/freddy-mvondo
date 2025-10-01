<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Gestion des Actes d\'État Civil')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            transition: transform 0.2s;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-grid-1x2"></i> Services en ligne
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.information') }}"><i class="bi bi-info-circle"></i> Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.contact') }}"><i class="bi bi-envelope"></i> Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.verify') }}"><i class="bi bi-patch-check"></i> Vérifier un acte</a>
                    </li>

                    @auth
                        @if(auth()->user()->isCitizen())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-briefcase"></i> Mes Services
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('civil-acts.index') }}">
                                            <i class="bi bi-file-text"></i> Actes d'État Civil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('urbanisme.index') }}">
                                            <i class="bi bi-building"></i> Urbanisme
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('civil-acts.create') }}">
                                    <i class="bi bi-plus-circle"></i> Nouvelle Demande
                                </a>
                            </li>
                        @elseif(auth()->user()->isAgent())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agent.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Tableau de Bord
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('agent.pending-review') }}">
                                    <i class="bi bi-clock-history"></i> En Attente
                                </a>
                            </li>
                        @elseif(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Administration
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                                <span class="badge bg-secondary ms-1">{{ ucfirst(auth()->user()->role) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-layout-text-window-reverse"></i> Mon Espace
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->isAgent())
                    <div class="col-md-2 sidebar p-3">
                        <div class="list-group list-group-flush">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-speedometer2"></i> Tableau de Bord
                                </a>
                                <a href="{{ route('admin.civil-acts') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-file-text"></i> Tous les Actes
                                </a>
                                <a href="{{ route('urbanisme.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-building"></i> Urbanisme
                                </a>
                                <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-people"></i> Utilisateurs
                                </a>
                                <a href="{{ route('admin.configuration') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-gear"></i> Configuration
                                </a>
                                <a href="{{ route('admin.reports') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-graph-up"></i> Rapports
                                </a>
                            @else
                                <a href="{{ route('agent.dashboard') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-speedometer2"></i> Tableau de Bord
                                </a>
                                <a href="{{ route('agent.pending-review') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-clock-history"></i> En Attente
                                </a>
                                <a href="{{ route('civil-acts.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-list-ul"></i> Tous les Actes
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-10 main-content p-4">
                @else
                    <div class="col-12 main-content p-4">
                @endif
            @else
                <div class="col-12 main-content p-4">
            @endauth
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html>