@extends('layouts.app')

@section('title', 'Paiement - ' . $civilAct->reference_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-credit-card"></i> Paiement
                </h4>
            </div>
            <div class="card-body">
                <!-- Payment Summary -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Résumé de la demande</h5>
                        <div class="row">
                            <div class="col-6">
                                <strong>Type d'acte:</strong><br>
                                {{ $civilAct->type_label }}
                            </div>
                            <div class="col-6">
                                <strong>Référence:</strong><br>
                                {{ $civilAct->reference_number }}
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Montant à payer:</h5>
                            <h4 class="text-primary mb-0">{{ number_format($civilAct->amount, 0, ',', ' ') }} XAF</h4>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('payments.store', $civilAct) }}" id="paymentForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Méthode de paiement *</label>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card payment-method" data-method="mobile_money">
                                    <div class="card-body text-center">
                                        <i class="bi bi-phone text-primary display-4 mb-3"></i>
                                        <h5>Mobile Money</h5>
                                        <p class="text-muted small">Orange Money, MTN Mobile Money</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card payment-method" data-method="bank_transfer">
                                    <div class="card-body text-center">
                                        <i class="bi bi-bank text-success display-4 mb-3"></i>
                                        <h5>Virement Bancaire</h5>
                                        <p class="text-muted small">Transfert bancaire</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="method" id="selectedMethod" required>
                        @error('method')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mobile Money Fields -->
                    <div id="mobileMoneyFields" class="payment-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Numéro de téléphone *</label>
                            <div class="input-group">
                                <span class="input-group-text">+237</span>
                                <input type="tel" class="form-control" name="phone" 
                                       placeholder="6XX XXX XXX" pattern="[0-9]{9}">
                            </div>
                            <div class="form-text">Entrez votre numéro de téléphone Mobile Money</div>
                        </div>
                    </div>

                    <!-- Bank Transfer Fields -->
                    <div id="bankTransferFields" class="payment-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Numéro de compte *</label>
                            <input type="text" class="form-control" name="account_number" 
                                   placeholder="Numéro de compte bancaire">
                            <div class="form-text">Entrez votre numéro de compte bancaire</div>
                        </div>
                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle"></i> Instructions de virement</h6>
                            <p class="mb-2">Effectuez un virement vers le compte suivant :</p>
                            <ul class="mb-0">
                                <li><strong>Banque:</strong> Banque Commerciale du Cameroun</li>
                                <li><strong>Compte:</strong> 1234567890</li>
                                <li><strong>Montant:</strong> {{ number_format($civilAct->amount, 0, ',', ' ') }} XAF</li>
                                <li><strong>Référence:</strong> {{ $civilAct->reference_number }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('civil-acts.show', $civilAct) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-success btn-lg" id="payButton" disabled>
                            <i class="bi bi-credit-card"></i> Payer {{ number_format($civilAct->amount, 0, ',', ' ') }} XAF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="bi bi-shield-check"></i> Paiement sécurisé</h5>
                <p class="text-muted mb-0">
                    Votre paiement est protégé par un cryptage SSL. Nous ne stockons pas vos informations bancaires.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const selectedMethodInput = document.getElementById('selectedMethod');
    const payButton = document.getElementById('payButton');
    const paymentFields = document.querySelectorAll('.payment-fields');

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Remove active class from all methods
            paymentMethods.forEach(m => m.classList.remove('border-primary', 'bg-light'));
            
            // Add active class to clicked method
            this.classList.add('border-primary', 'bg-light');
            
            // Set the selected method
            const methodValue = this.dataset.method;
            selectedMethodInput.value = methodValue;
            
            // Hide all payment fields
            paymentFields.forEach(field => {
                field.style.display = 'none';
            });
            
            // Show the relevant payment fields
            const fieldsId = methodValue.replace('_', '') + 'Fields';
            const fieldsElement = document.getElementById(fieldsId);
            if (fieldsElement) {
                fieldsElement.style.display = 'block';
            }
            
            // Enable pay button
            payButton.disabled = false;
        });
    });

    // Form submission with loading state
    document.getElementById('paymentForm').addEventListener('submit', function() {
        payButton.disabled = true;
        payButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Traitement en cours...';
    });
});
</script>

<style>
.payment-method {
    cursor: pointer;
    transition: all 0.2s;
}

.payment-method:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.payment-method.border-primary {
    border-width: 2px !important;
}
</style>
@endsection
