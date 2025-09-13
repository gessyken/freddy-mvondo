@extends('layouts.app')

@section('title', 'Accueil - Gestion des Actes d\'État Civil')

@section('content')
<div class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Gestion des Actes d'État Civil</h1>
                <p class="lead mb-4">
                    Digitalisez vos démarches administratives. Demandez et obtenez vos actes d'état civil 
                    (naissance, mariage, décès) en ligne, de manière simple et sécurisée.
                </p>
                <div class="d-flex gap-3">
                    @auth
                        <a href="{{ route('civil-acts.create') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-plus-circle"></i> Nouvelle Demande
                        </a>
                        <a href="{{ route('civil-acts.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-list-ul"></i> Mes Demandes
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-person-plus"></i> Créer un Compte
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Se Connecter
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="bi bi-file-text display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Services Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Nos Services</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-baby text-primary display-4 mb-3"></i>
                    <h5 class="card-title">Acte de Naissance</h5>
                    <p class="card-text">
                        Déclaration et obtention d'acte de naissance dans les 30 jours suivant la naissance.
                    </p>
                    <div class="mt-3">
                        <span class="badge bg-success">7 200 XAF</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-heart text-danger display-4 mb-3"></i>
                    <h5 class="card-title">Acte de Mariage</h5>
                    <p class="card-text">
                        Enregistrement et obtention d'acte de mariage avec tous les documents requis.
                    </p>
                    <div class="mt-3">
                        <span class="badge bg-success">15 000 XAF</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-flower1 text-secondary display-4 mb-3"></i>
                    <h5 class="card-title">Acte de Décès</h5>
                    <p class="card-text">
                        Déclaration et obtention d'acte de décès avec les pièces justificatives.
                    </p>
                    <div class="mt-3">
                        <span class="badge bg-success">5 000 XAF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Comment ça marche ?</h2>
        </div>
        <div class="col-md-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold">1</span>
                </div>
                <h5>Créez votre compte</h5>
                <p class="text-muted">Inscrivez-vous gratuitement avec votre email et téléphone.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold">2</span>
                </div>
                <h5>Remplissez le formulaire</h5>
                <p class="text-muted">Choisissez le type d'acte et remplissez les informations requises.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold">3</span>
                </div>
                <h5>Uploadez les documents</h5>
                <p class="text-muted">Téléchargez les pièces justificatives requises.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold">4</span>
                </div>
                <h5>Payez et attendez</h5>
                <p class="text-muted">Effectuez le paiement et suivez le traitement de votre demande.</p>
            </div>
        </div>
    </div>

    <!-- Verification Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h3 class="card-title mb-4">
                        <i class="bi bi-shield-check text-success"></i> Vérification d'Acte
                    </h3>
                    <p class="card-text mb-4">
                        Vérifiez l'authenticité d'un acte d'état civil en utilisant le numéro de référence ou le QR code.
                    </p>
                    <form action="{{ route('public.verify') }}" method="GET" class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" 
                                       name="reference_number" 
                                       placeholder="Entrez le numéro de référence"
                                       required>
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <i class="bi bi-search"></i> Vérifier
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="card-title mb-4">Besoin d'aide ?</h3>
                    <p class="card-text mb-4">
                        Notre équipe est là pour vous accompagner dans vos démarches.
                    </p>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-telephone text-primary display-6"></i>
                            <h5>Appelez-nous</h5>
                            <p class="text-muted">+237 XXX XXX XXX</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-envelope text-primary display-6"></i>
                            <h5>Écrivez-nous</h5>
                            <p class="text-muted">contact@actescivils.cm</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-geo-alt text-primary display-6"></i>
                            <h5>Visitez-nous</h5>
                            <p class="text-muted">Mairie de Yaoundé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
