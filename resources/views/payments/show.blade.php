@extends('layouts.app')

@section('title', 'Détails du Paiement - ' . $payment->payment_reference)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-credit-card"></i> Détails du Paiement
                </h4>
            </div>
            <div class="card-body">
                <!-- Payment Status -->
                <div class="text-center mb-4">
                    @if($payment->status === 'success')
                        <i class="bi bi-check-circle text-success display-1"></i>
                        <h3 class="text-success mt-3">Paiement Réussi</h3>
                    @elseif($payment->status === 'pending')
                        <i class="bi bi-clock text-warning display-1"></i>
                        <h3 class="text-warning mt-3">Paiement en Attente</h3>
                    @elseif($payment->status === 'failed')
                        <i class="bi bi-x-circle text-danger display-1"></i>
                        <h3 class="text-danger mt-3">Paiement Échoué</h3>
                    @else
                        <i class="bi bi-question-circle text-secondary display-1"></i>
                        <h3 class="text-secondary mt-3">Statut Inconnu</h3>
                    @endif
                </div>

                <!-- Payment Details -->
                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Montant:</strong><br>
                        <span class="fs-4 text-primary">{{ number_format($payment->amount, 0, ',', ' ') }} XAF</span>
                    </div>
                    <div class="col-6">
                        <strong>Méthode:</strong><br>
                        <span class="badge bg-info fs-6">{{ $payment->method_label }}</span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Référence:</strong><br>
                        <code>{{ $payment->payment_reference }}</code>
                    </div>
                    <div class="col-6">
                        <strong>Transaction ID:</strong><br>
                        <code>{{ $payment->transaction_id }}</code>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Date de création:</strong><br>
                        {{ $payment->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="col-6">
                        <strong>Date de traitement:</strong><br>
                        {{ $payment->processed_at ? $payment->processed_at->format('d/m/Y à H:i') : 'Non traité' }}
                    </div>
                </div>

                @if($payment->failure_reason)
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-exclamation-triangle"></i> Raison de l'échec</h6>
                        <p class="mb-0">{{ $payment->failure_reason }}</p>
                    </div>
                @endif

                <!-- Civil Act Information -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Demande associée</h6>
                        <div class="row">
                            <div class="col-6">
                                <strong>Type:</strong><br>
                                {{ $payment->civilAct->type_label }}
                            </div>
                            <div class="col-6">
                                <strong>Référence:</strong><br>
                                <code>{{ $payment->civilAct->reference_number }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('civil-acts.show', $payment->civilAct) }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Retour à la demande
                    </a>
                    
                    @if($payment->status === 'success')
                        <a href="{{ route('civil-acts.show', $payment->civilAct) }}" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Continuer
                        </a>
                    @elseif($payment->status === 'failed')
                        <a href="{{ route('payments.create', $payment->civilAct) }}" class="btn btn-warning">
                            <i class="bi bi-arrow-clockwise"></i> Réessayer
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        @if($payment->status === 'pending')
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Instructions de Paiement</h5>
                </div>
                <div class="card-body">
                    @if($payment->method === 'mobile_money')
                        <div class="alert alert-info">
                            <h6><i class="bi bi-phone"></i> Mobile Money</h6>
                            <p class="mb-2">Pour effectuer votre paiement :</p>
                            <ol class="mb-0">
                                <li>Ouvrez votre application Mobile Money</li>
                                <li>Sélectionnez "Payer une facture"</li>
                                <li>Entrez le code : <strong>{{ $payment->payment_reference }}</strong></li>
                                <li>Confirmez le montant : <strong>{{ number_format($payment->amount, 0, ',', ' ') }} XAF</strong></li>
                                <li>Validez la transaction</li>
                            </ol>
                        </div>
                    @elseif($payment->method === 'bank_transfer')
                        <div class="alert alert-info">
                            <h6><i class="bi bi-bank"></i> Virement Bancaire</h6>
                            <p class="mb-2">Effectuez un virement vers :</p>
                            <ul class="mb-0">
                                <li><strong>Banque:</strong> Banque Commerciale du Cameroun</li>
                                <li><strong>Compte:</strong> 1234567890</li>
                                <li><strong>Montant:</strong> {{ number_format($payment->amount, 0, ',', ' ') }} XAF</li>
                                <li><strong>Référence:</strong> {{ $payment->payment_reference }}</li>
                            </ul>
                        </div>
                    @endif
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Le statut sera mis à jour automatiquement une fois le paiement confirmé.
                        </small>
                    </div>
                </div>
            </div>
        @endif

        <!-- Security Notice -->
        <div class="card mt-4">
            <div class="card-body">
                <h6><i class="bi bi-shield-check"></i> Sécurité</h6>
                <p class="text-muted mb-0">
                    Votre paiement est protégé par un cryptage SSL. Nous ne stockons pas vos informations bancaires.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
