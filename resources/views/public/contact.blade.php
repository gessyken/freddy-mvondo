@extends('layouts.app')

@section('title', 'Contact - Actes d\'État Civil')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">
                <i class="bi bi-telephone text-primary"></i> Contactez-nous
            </h1>

            <div class="row">
                <!-- Formulaire de contact -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Envoyez-nous un message</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nom complet *</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sujet *</label>
                                    <select class="form-select" required>
                                        <option value="">Sélectionner un sujet</option>
                                        <option value="general">Question générale</option>
                                        <option value="technical">Problème technique</option>
                                        <option value="payment">Question de paiement</option>
                                        <option value="document">Question sur les documents</option>
                                        <option value="other">Autre</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message *</label>
                                    <textarea class="form-control" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-send"></i> Envoyer le message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Informations de contact -->
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Nos coordonnées</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6><i class="bi bi-geo-alt text-primary"></i> Adresse</h6>
                                <p class="text-muted">
                                    Mairie de Yaoundé<br>
                                    Avenue du 20 Mai<br>
                                    Yaoundé, Cameroun
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <h6><i class="bi bi-telephone text-primary"></i> Téléphone</h6>
                                <p class="text-muted">
                                    <strong>Standard:</strong> +237 XXX XXX XXX<br>
                                    <strong>Urgences:</strong> +237 XXX XXX XXX
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <h6><i class="bi bi-envelope text-primary"></i> Email</h6>
                                <p class="text-muted">
                                    <strong>Général:</strong> contact@actescivils.cm<br>
                                    <strong>Support:</strong> support@actescivils.cm<br>
                                    <strong>Technique:</strong> tech@actescivils.cm
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <h6><i class="bi bi-clock text-primary"></i> Heures d'ouverture</h6>
                                <p class="text-muted">
                                    <strong>Lundi - Vendredi:</strong> 8h00 - 17h00<br>
                                    <strong>Samedi:</strong> 8h00 - 12h00<br>
                                    <strong>Dimanche:</strong> Fermé
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Carte (placeholder) -->
                    <div class="card">
                        <div class="card-body">
                            <h6><i class="bi bi-map text-primary"></i> Localisation</h6>
                            <div class="bg-light p-4 text-center rounded">
                                <i class="bi bi-geo-alt display-4 text-muted"></i>
                                <p class="text-muted mt-2">Carte interactive</p>
                                <small class="text-muted">Mairie de Yaoundé, Avenue du 20 Mai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ rapide -->
            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="text-center mb-4">Questions Fréquentes</h2>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-question-circle text-primary"></i>
                                Combien de temps prend le traitement ?
                            </h6>
                            <p class="card-text text-muted">
                                Le traitement d'une demande prend généralement 3 à 5 jours ouvrables après réception du paiement et validation des documents.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-question-circle text-primary"></i>
                                Puis-je payer en espèces ?
                            </h6>
                            <p class="card-text text-muted">
                                Oui, vous pouvez payer en espèces en vous rendant directement à la mairie. Contactez-nous pour les modalités.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-question-circle text-primary"></i>
                                Mon acte est-il valide à l'étranger ?
                            </h6>
                            <p class="card-text text-muted">
                                Les actes générés sont conformes aux standards internationaux et peuvent être légalisés si nécessaire.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-question-circle text-primary"></i>
                                Que faire si j'ai oublié mon mot de passe ?
                            </h6>
                            <p class="card-text text-muted">
                                Contactez notre support technique qui vous aidera à récupérer l'accès à votre compte.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liens utiles -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="mb-4">Liens Utiles</h5>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('public.information') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-info-circle"></i> Informations
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('public.faq') }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-question-circle"></i> FAQ
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
