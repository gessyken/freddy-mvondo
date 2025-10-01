@extends('layouts.app')

@section('title', 'Informations - Services Municipaux')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="text-center mb-5">
                <i class="bi bi-info-circle text-primary"></i> Informations sur les Services Municipaux
            </h1>

            <!-- Navigation Tabs -->
            <ul class="nav nav-pills nav-fill mb-5" id="servicesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="civil-acts-tab" data-bs-toggle="tab" data-bs-target="#civil-acts" type="button" role="tab" aria-controls="civil-acts" aria-selected="true">
                        <i class="bi bi-file-text"></i> État Civil
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="urbanisme-tab" data-bs-toggle="tab" data-bs-target="#urbanisme" type="button" role="tab" aria-controls="urbanisme" aria-selected="false">
                        <i class="bi bi-building"></i> Urbanisme
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="servicesTabContent">
                <!-- État Civil Content -->
                <div class="tab-pane fade show active" id="civil-acts" role="tabpanel" aria-labelledby="civil-acts-tab">
                    <h2 class="mb-4">Actes d'État Civil</h2>
                    
                    <!-- Types d'actes -->
                    <div class="row mb-5">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-baby text-primary display-4 mb-3"></i>
                                    <h4>Acte de Naissance</h4>
                                    <p class="text-muted">Déclaration et obtention d'acte de naissance</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">7 200 XAF</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-heart text-danger display-4 mb-3"></i>
                                    <h4>Acte de Mariage</h4>
                                    <p class="text-muted">Enregistrement et obtention d'acte de mariage</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">15 000 XAF</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-flower1 text-secondary display-4 mb-3"></i>
                                    <h4>Acte de Décès</h4>
                                    <p class="text-muted">Déclaration et obtention d'acte de décès</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">5 000 XAF</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents requis -->
                    <h3 class="mb-4">Documents Requis</h3>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white"><h5 class="mb-0">Naissance</h5></div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-file-text me-2"></i>Déclaration de naissance</li>
                                        <li class="list-group-item"><i class="bi bi-person-badge me-2"></i>CNI des parents</li>
                                        <li class="list-group-item"><i class="bi bi-people me-2"></i>CNI des témoins</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-danger text-white"><h5 class="mb-0">Mariage</h5></div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-file-text me-2"></i>Actes de naissance des époux</li>
                                        <li class="list-group-item"><i class="bi bi-person-badge me-2"></i>CNI des époux</li>
                                        <li class="list-group-item"><i class="bi bi-file-check me-2"></i>Certificats de célibat</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-secondary text-white"><h5 class="mb-0">Décès</h5></div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-file-text me-2"></i>Déclaration de décès</li>
                                        <li class="list-group-item"><i class="bi bi-person-badge me-2"></i>CNI du déclarant</li>
                                        <li class="list-group-item"><i class="bi bi-people me-2"></i>CNI des témoins</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Urbanisme Content -->
                <div class="tab-pane fade" id="urbanisme" role="tabpanel" aria-labelledby="urbanisme-tab">
                    <h2 class="mb-4">Services d'Urbanisme</h2>
                    
                    <!-- Types de services -->
                    <div class="row mb-5">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-building text-info display-4 mb-3"></i>
                                    <h4>Permis de Construire</h4>
                                    <p class="text-muted">Autorisation pour la construction de nouveaux bâtiments.</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">50 000 XAF</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-map text-warning display-4 mb-3"></i>
                                    <h4>Certificat d'Urbanisme</h4>
                                    <p class="text-muted">Information sur les règles d'urbanisme applicables à un terrain.</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">25 000 XAF</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-tools text-dark display-4 mb-3"></i>
                                    <h4>Permis de Démolir</h4>
                                    <p class="text-muted">Autorisation pour la démolition totale ou partielle d'un bâtiment.</p>
                                    <div class="mb-3"><span class="badge bg-success fs-6">30 000 XAF</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents requis -->
                    <h3 class="mb-4">Documents Requis</h3>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-info text-white"><h5 class="mb-0">Permis de Construire</h5></div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-file-text me-2"></i>Titre de propriété</li>
                                        <li class="list-group-item"><i class="bi bi-map me-2"></i>Plan de situation</li>
                                        <li class="list-group-item"><i class="bi bi-aspect-ratio me-2"></i>Plans de construction (architecte)</li>
                                        <li class="list-group-item"><i class="bi bi-calculator me-2"></i>Devis estimatif</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-warning text-white"><h5 class="mb-0">Certificat d'Urbanisme</h5></div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-file-text me-2"></i>Titre de propriété</li>
                                        <li class="list-group-item"><i class="bi bi-map me-2"></i>Plan de situation</li>
                                        <li class="list-group-item"><i class="bi bi-question-circle me-2"></i>Note de renseignements</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Processus (commun) -->
            <div class="row mb-5">
                <div class="col-12"><h2 class="text-center mb-4">Comment Procéder ?</h2></div>
                <div class="col-md-3 mb-4 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;"><span class="fw-bold">1</span></div>
                    <h5>Créer un compte</h5>
                    <p class="text-muted">Inscrivez-vous gratuitement.</p>
                </div>
                <div class="col-md-3 mb-4 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;"><span class="fw-bold">2</span></div>
                    <h5>Remplir le formulaire</h5>
                    <p class="text-muted">Choisissez le service et remplissez les informations.</p>
                </div>
                <div class="col-md-3 mb-4 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;"><span class="fw-bold">3</span></div>
                    <h5>Uploader les documents</h5>
                    <p class="text-muted">Téléchargez les pièces justificatives.</p>
                </div>
                <div class="col-md-3 mb-4 text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;"><span class="fw-bold">4</span></div>
                    <h5>Payer et attendre</h5>
                    <p class="text-muted">Payez les frais et suivez votre demande.</p>
                </div>
            </div>

            <!-- Contact -->
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3 class="mb-4">Besoin d'Aide ?</h3>
                            <p class="lead mb-4">Notre équipe est là pour vous accompagner.</p>
                            <div class="row">
                                <div class="col-md-4 mb-3"><i class="bi bi-telephone text-primary display-6"></i><h5>Appelez-nous</h5><p class="text-muted">+237 XXX XXX XXX</p></div>
                                <div class="col-md-4 mb-3"><i class="bi bi-envelope text-primary display-6"></i><h5>Écrivez-nous</h5><p class="text-muted">contact@actescivils.cm</p></div>
                                <div class="col-md-4 mb-3"><i class="bi bi-geo-alt text-primary display-6"></i><h5>Visitez-nous</h5><p class="text-muted">Mairie de Yaoundé</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection