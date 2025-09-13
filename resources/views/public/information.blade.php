@extends('layouts.app')

@section('title', 'Informations - Actes d\'État Civil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">
                <i class="bi bi-info-circle text-primary"></i> Informations sur les Actes d'État Civil
            </h1>

            <!-- Types d'actes -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Types d'Actes Disponibles</h2>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-baby text-primary display-4 mb-3"></i>
                            <h4>Acte de Naissance</h4>
                            <p class="text-muted">Déclaration et obtention d'acte de naissance</p>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6">7 200 XAF</span>
                            </div>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check text-success"></i> Délai: 30 jours après naissance</li>
                                <li><i class="bi bi-check text-success"></i> Documents requis</li>
                                <li><i class="bi bi-check text-success"></i> Traitement rapide</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-heart text-danger display-4 mb-3"></i>
                            <h4>Acte de Mariage</h4>
                            <p class="text-muted">Enregistrement et obtention d'acte de mariage</p>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6">15 000 XAF</span>
                            </div>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check text-success"></i> Documents complets</li>
                                <li><i class="bi bi-check text-success"></i> Photos requises</li>
                                <li><i class="bi bi-check text-success"></i> Certificats légaux</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-flower1 text-secondary display-4 mb-3"></i>
                            <h4>Acte de Décès</h4>
                            <p class="text-muted">Déclaration et obtention d'acte de décès</p>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6">5 000 XAF</span>
                            </div>
                            <ul class="list-unstyled text-start">
                                <li><i class="bi bi-check text-success"></i> Déclaration rapide</li>
                                <li><i class="bi bi-check text-success"></i> Documents simples</li>
                                <li><i class="bi bi-check text-success"></i> Témoins requis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Processus -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Comment Procéder ?</h2>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">1</span>
                        </div>
                        <h5>Créer un compte</h5>
                        <p class="text-muted">Inscrivez-vous gratuitement avec votre email et téléphone.</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">2</span>
                        </div>
                        <h5>Remplir le formulaire</h5>
                        <p class="text-muted">Choisissez le type d'acte et remplissez les informations requises.</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">3</span>
                        </div>
                        <h5>Uploader les documents</h5>
                        <p class="text-muted">Téléchargez les pièces justificatives requises.</p>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">4</span>
                        </div>
                        <h5>Payer et attendre</h5>
                        <p class="text-muted">Effectuez le paiement et suivez le traitement de votre demande.</p>
                    </div>
                </div>
            </div>

            <!-- Documents requis -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Documents Requis par Type d'Acte</h2>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Acte de Naissance</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-file-text text-primary me-2"></i>
                                    Déclaration de naissance
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-person-badge text-primary me-2"></i>
                                    CNI des parents
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-people text-primary me-2"></i>
                                    CNI des témoins
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Acte de Mariage</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-file-text text-danger me-2"></i>
                                    Actes de naissance des époux
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-person-badge text-danger me-2"></i>
                                    CNI des époux
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-file-check text-danger me-2"></i>
                                    Certificats de célibat
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-house text-danger me-2"></i>
                                    Certificat de domicile
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-camera text-danger me-2"></i>
                                    Photos 4x4
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Acte de Décès</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-file-text text-secondary me-2"></i>
                                    Déclaration de décès
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-person-badge text-secondary me-2"></i>
                                    CNI du déclarant
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-people text-secondary me-2"></i>
                                    CNI des témoins
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="bi bi-heart text-secondary me-2"></i>
                                    Acte de mariage (si marié)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Délais et tarifs -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="mb-4">Délais et Tarifs</h2>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Délais de Déclaration</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Naissance:</strong></td>
                                    <td>30 jours après la naissance</td>
                                </tr>
                                <tr>
                                    <td><strong>Mariage:</strong></td>
                                    <td>Immédiat</td>
                                </tr>
                                <tr>
                                    <td><strong>Décès:</strong></td>
                                    <td>Immédiat</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tarifs</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Acte de naissance:</strong></td>
                                    <td><span class="badge bg-success">7 200 XAF</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Acte de mariage:</strong></td>
                                    <td><span class="badge bg-success">15 000 XAF</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Acte de décès:</strong></td>
                                    <td><span class="badge bg-success">5 000 XAF</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="mb-4">Besoin d'Aide ?</h3>
                            <p class="lead mb-4">
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
    </div>
</div>
@endsection
