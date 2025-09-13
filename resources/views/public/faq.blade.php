@extends('layouts.app')

@section('title', 'FAQ - Actes d\'État Civil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">
                <i class="bi bi-question-circle text-primary"></i> Questions Fréquentes
            </h1>

            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $index }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $index }}">
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" 
                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Section de recherche -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Vous ne trouvez pas votre réponse ?</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-4">
                                Si vous ne trouvez pas la réponse à votre question dans notre FAQ, n'hésitez pas à nous contacter.
                            </p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-1">Appelez-nous</h6>
                                            <p class="text-muted mb-0">+237 XXX XXX XXX</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope text-primary me-3"></i>
                                        <div>
                                            <h6 class="mb-1">Écrivez-nous</h6>
                                            <p class="text-muted mb-0">contact@actescivils.cm</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('public.contact') }}" class="btn btn-primary">
                                    <i class="bi bi-chat-dots"></i> Nous contacter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catégories de questions -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center mb-4">Catégories de Questions</h3>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-person-plus text-primary display-4 mb-3"></i>
                            <h5>Inscription et Compte</h5>
                            <p class="text-muted">Questions sur la création de compte, connexion, et gestion du profil.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-file-text text-primary display-4 mb-3"></i>
                            <h5>Demandes d'Actes</h5>
                            <p class="text-muted">Comment créer une demande, quels documents fournir, délais.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-credit-card text-primary display-4 mb-3"></i>
                            <h5>Paiements</h5>
                            <p class="text-muted">Méthodes de paiement, problèmes de transaction, remboursements.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-clock text-primary display-4 mb-3"></i>
                            <h5>Délais et Traitement</h5>
                            <p class="text-muted">Temps de traitement, suivi des demandes, statuts.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-download text-primary display-4 mb-3"></i>
                            <h5>Actes et Documents</h5>
                            <p class="text-muted">Téléchargement des actes, vérification, légalisation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-gear text-primary display-4 mb-3"></i>
                            <h5>Problèmes Techniques</h5>
                            <p class="text-muted">Erreurs du système, problèmes d'upload, navigation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liens utiles -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="mb-4">Ressources Utiles</h5>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('public.information') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-info-circle"></i> Informations
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('public.contact') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-telephone"></i> Contact
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('public.verify') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-shield-check"></i> Vérifier un acte
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-person-plus"></i> Créer un compte
                                    </a>
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
