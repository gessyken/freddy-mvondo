@extends('layouts.app')

@section('title', 'Modifier la Demande - ' . $civilAct->reference_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-pencil"></i> Modifier la Demande
                    <small class="text-muted">- {{ $civilAct->reference_number }}</small>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('civil-acts.update', $civilAct) }}" id="civilActForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Type Selection (disabled) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Type d'acte demandé</label>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card {{ $civilAct->type === 'birth' ? 'border-primary bg-light' : '' }}">
                                    <div class="card-body text-center">
                                        <i class="bi bi-baby text-primary display-4 mb-3"></i>
                                        <h5>Acte de Naissance</h5>
                                        <p class="text-muted small">Déclaration de naissance</p>
                                        <div class="badge bg-success">{{ number_format($pricing['birth_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card {{ $civilAct->type === 'marriage' ? 'border-primary bg-light' : '' }}">
                                    <div class="card-body text-center">
                                        <i class="bi bi-heart text-danger display-4 mb-3"></i>
                                        <h5>Acte de Mariage</h5>
                                        <p class="text-muted small">Enregistrement de mariage</p>
                                        <div class="badge bg-success">{{ number_format($pricing['marriage_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card {{ $civilAct->type === 'death' ? 'border-primary bg-light' : '' }}">
                                    <div class="card-body text-center">
                                        <i class="bi bi-flower1 text-secondary display-4 mb-3"></i>
                                        <h5>Acte de Décès</h5>
                                        <p class="text-muted small">Déclaration de décès</p>
                                        <div class="badge bg-success">{{ number_format($pricing['death_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="{{ $civilAct->type }}">
                    </div>

                    <!-- Birth Certificate Form -->
                    @if($civilAct->type === 'birth')
                        <div id="birthForm" class="form-section">
                            <h5 class="mb-3">Informations sur l'enfant</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prénom(s) *</label>
                                    <input type="text" class="form-control" name="data[child_first_name]" 
                                           value="{{ old('data.child_first_name', $civilAct->data['child_first_name'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom de famille *</label>
                                    <input type="text" class="form-control" name="data[child_last_name]" 
                                           value="{{ old('data.child_last_name', $civilAct->data['child_last_name'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de naissance *</label>
                                    <input type="date" class="form-control" name="data[child_birth_date]" 
                                           value="{{ old('data.child_birth_date', $civilAct->data['child_birth_date'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lieu de naissance *</label>
                                    <input type="text" class="form-control" name="data[child_birth_place]" 
                                           value="{{ old('data.child_birth_place', $civilAct->data['child_birth_place'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sexe *</label>
                                    <select class="form-select" name="data[child_gender]">
                                        <option value="">Sélectionner</option>
                                        <option value="M" {{ old('data.child_gender', $civilAct->data['child_gender'] ?? '') === 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('data.child_gender', $civilAct->data['child_gender'] ?? '') === 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="mb-3 mt-4">Informations sur les parents</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom du père *</label>
                                    <input type="text" class="form-control" name="data[father_name]" 
                                           value="{{ old('data.father_name', $civilAct->data['father_name'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom de la mère *</label>
                                    <input type="text" class="form-control" name="data[mother_name]" 
                                           value="{{ old('data.mother_name', $civilAct->data['mother_name'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession du père</label>
                                    <input type="text" class="form-control" name="data[father_profession]" 
                                           value="{{ old('data.father_profession', $civilAct->data['father_profession'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession de la mère</label>
                                    <input type="text" class="form-control" name="data[mother_profession]" 
                                           value="{{ old('data.mother_profession', $civilAct->data['mother_profession'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Marriage Certificate Form -->
                    @if($civilAct->type === 'marriage')
                        <div id="marriageForm" class="form-section">
                            <h5 class="mb-3">Informations sur les époux</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom de l'époux *</label>
                                    <input type="text" class="form-control" name="data[husband_name]" 
                                           value="{{ old('data.husband_name', $civilAct->data['husband_name'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom de l'épouse *</label>
                                    <input type="text" class="form-control" name="data[wife_name]" 
                                           value="{{ old('data.wife_name', $civilAct->data['wife_name'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de naissance de l'époux *</label>
                                    <input type="date" class="form-control" name="data[husband_birth_date]" 
                                           value="{{ old('data.husband_birth_date', $civilAct->data['husband_birth_date'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de naissance de l'épouse *</label>
                                    <input type="date" class="form-control" name="data[wife_birth_date]" 
                                           value="{{ old('data.wife_birth_date', $civilAct->data['wife_birth_date'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de mariage *</label>
                                    <input type="date" class="form-control" name="data[marriage_date]" 
                                           value="{{ old('data.marriage_date', $civilAct->data['marriage_date'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lieu de mariage *</label>
                                    <input type="text" class="form-control" name="data[marriage_place]" 
                                           value="{{ old('data.marriage_place', $civilAct->data['marriage_place'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Death Certificate Form -->
                    @if($civilAct->type === 'death')
                        <div id="deathForm" class="form-section">
                            <h5 class="mb-3">Informations sur le défunt</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom complet du défunt *</label>
                                    <input type="text" class="form-control" name="data[deceased_name]" 
                                           value="{{ old('data.deceased_name', $civilAct->data['deceased_name'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de décès *</label>
                                    <input type="date" class="form-control" name="data[death_date]" 
                                           value="{{ old('data.death_date', $civilAct->data['death_date'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lieu de décès *</label>
                                    <input type="text" class="form-control" name="data[death_place]" 
                                           value="{{ old('data.death_place', $civilAct->data['death_place'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cause du décès</label>
                                    <input type="text" class="form-control" name="data[death_cause]" 
                                           value="{{ old('data.death_cause', $civilAct->data['death_cause'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom du déclarant *</label>
                                    <input type="text" class="form-control" name="data[declarant_name]" 
                                           value="{{ old('data.declarant_name', $civilAct->data['declarant_name'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lien de parenté *</label>
                                    <input type="text" class="form-control" name="data[relationship]" 
                                           value="{{ old('data.relationship', $civilAct->data['relationship'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('civil-acts.show', $civilAct) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
