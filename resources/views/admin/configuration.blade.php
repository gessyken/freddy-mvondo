@extends('layouts.app')

@section('title', 'Configuration du Système')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-gear"></i> Configuration du Système
    </h2>
</div>

<form method="POST" action="{{ route('admin.configuration.update') }}">
    @csrf
    
    <div class="row">
        <!-- Pricing Configuration -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-currency-exchange"></i> Tarification
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Acte de naissance (XAF)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pricing[birth_certificate]" 
                                   value="{{ $pricing['birth_certificate'] }}" min="0" step="100">
                            <span class="input-group-text">XAF</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Acte de mariage (XAF)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pricing[marriage_certificate]" 
                                   value="{{ $pricing['marriage_certificate'] }}" min="0" step="100">
                            <span class="input-group-text">XAF</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Acte de décès (XAF)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pricing[death_certificate]" 
                                   value="{{ $pricing['death_certificate'] }}" min="0" step="100">
                            <span class="input-group-text">XAF</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deadlines Configuration -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock"></i> Délais de Déclaration
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Déclaration de naissance (jours)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="deadlines[birth_declaration]" 
                                   value="{{ $deadlines['birth_declaration'] }}" min="0" max="365">
                            <span class="input-group-text">jours</span>
                        </div>
                        <div class="form-text">Délai maximum pour déclarer une naissance</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Déclaration de mariage (jours)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="deadlines[marriage_declaration]" 
                                   value="{{ $deadlines['marriage_declaration'] }}" min="0" max="365">
                            <span class="input-group-text">jours</span>
                        </div>
                        <div class="form-text">Délai maximum pour déclarer un mariage</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Déclaration de décès (jours)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="deadlines[death_declaration]" 
                                   value="{{ $deadlines['death_declaration'] }}" min="0" max="365">
                            <span class="input-group-text">jours</span>
                        </div>
                        <div class="form-text">Délai maximum pour déclarer un décès</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Settings -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-sliders"></i> Paramètres Système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'organisation</label>
                                <input type="text" class="form-control" value="Mairie de Yaoundé" readonly>
                                <div class="form-text">Nom de l'administration</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email de contact</label>
                                <input type="email" class="form-control" value="contact@actescivils.cm" readonly>
                                <div class="form-text">Email principal de contact</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Téléphone de contact</label>
                                <input type="tel" class="form-control" value="+237 XXX XXX XXX" readonly>
                                <div class="form-text">Numéro de téléphone principal</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <textarea class="form-control" rows="3" readonly>Mairie de Yaoundé
Avenue du 20 Mai
Yaoundé, Cameroun</textarea>
                                <div class="form-text">Adresse de l'administration</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Heures d'ouverture</label>
                                <input type="text" class="form-control" value="Lundi - Vendredi: 8h00 - 17h00" readonly>
                                <div class="form-text">Horaires de fonctionnement</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Settings -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-credit-card"></i> Configuration des Paiements
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Mobile Money</h6>
                            <div class="mb-3">
                                <label class="form-label">Orange Money</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="+237 XXX XXX XXX" readonly>
                                    <span class="input-group-text">Actif</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">MTN Mobile Money</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="+237 XXX XXX XXX" readonly>
                                    <span class="input-group-text">Actif</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Virements Bancaires</h6>
                            <div class="mb-3">
                                <label class="form-label">Banque</label>
                                <input type="text" class="form-control" value="Banque Commerciale du Cameroun" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Numéro de compte</label>
                                <input type="text" class="form-control" value="1234567890" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Code SWIFT</label>
                                <input type="text" class="form-control" value="BCCMCMCX" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i> Sauvegarder la configuration
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
