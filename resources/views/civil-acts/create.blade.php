@extends('layouts.app')

@section('title', 'Nouvelle Demande d\'Acte Civil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Nouvelle Demande d'Acte Civil
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('civil-acts.store') }}" id="civilActForm">
                    @csrf
                    
                    <!-- Type Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Type d'acte demandé *</label>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 type-card" data-type="birth">
                                    <div class="card-body text-center">
                                        <i class="bi bi-baby text-primary display-4 mb-3"></i>
                                        <h5>Acte de Naissance</h5>
                                        <p class="text-muted small">Déclaration de naissance</p>
                                        <div class="badge bg-success">{{ number_format($pricing['birth_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 type-card" data-type="marriage">
                                    <div class="card-body text-center">
                                        <i class="bi bi-heart text-danger display-4 mb-3"></i>
                                        <h5>Acte de Mariage</h5>
                                        <p class="text-muted small">Enregistrement de mariage</p>
                                        <div class="badge bg-success">{{ number_format($pricing['marriage_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 type-card" data-type="death">
                                    <div class="card-body text-center">
                                        <i class="bi bi-flower1 text-secondary display-4 mb-3"></i>
                                        <h5>Acte de Décès</h5>
                                        <p class="text-muted small">Déclaration de décès</p>
                                        <div class="badge bg-success">{{ number_format($pricing['death_certificate'], 0, ',', ' ') }} XAF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="type" id="selectedType" required>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Birth Certificate Form -->
                    <div id="birthForm" class="form-section" style="display: none;">
                        <h5 class="mb-3">Informations sur l'enfant</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom(s) *</label>
                                <input type="text" class="form-control" name="data[child_first_name]" value="{{ old('data.child_first_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de famille *</label>
                                <input type="text" class="form-control" name="data[child_last_name]" value="{{ old('data.child_last_name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de naissance *</label>
                                <input type="date" class="form-control" name="data[child_birth_date]" value="{{ old('data.child_birth_date') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lieu de naissance *</label>
                                <input type="text" class="form-control" name="data[child_birth_place]" value="{{ old('data.child_birth_place') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sexe *</label>
                                <select class="form-select" name="data[child_gender]">
                                    <option value="">Sélectionner</option>
                                    <option value="M" {{ old('data.child_gender') === 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('data.child_gender') === 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Informations sur les parents</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom du père *</label>
                                <input type="text" class="form-control" name="data[father_name]" value="{{ old('data.father_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de la mère *</label>
                                <input type="text" class="form-control" name="data[mother_name]" value="{{ old('data.mother_name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession du père</label>
                                <input type="text" class="form-control" name="data[father_profession]" value="{{ old('data.father_profession') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession de la mère</label>
                                <input type="text" class="form-control" name="data[mother_profession]" value="{{ old('data.mother_profession') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Marriage Certificate Form -->
                    <div id="marriageForm" class="form-section" style="display: none;">
                        <h5 class="mb-3">Informations sur les époux</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'époux *</label>
                                <input type="text" class="form-control" name="data[husband_name]" value="{{ old('data.husband_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'épouse *</label>
                                <input type="text" class="form-control" name="data[wife_name]" value="{{ old('data.wife_name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de naissance de l'époux *</label>
                                <input type="date" class="form-control" name="data[husband_birth_date]" value="{{ old('data.husband_birth_date') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de naissance de l'épouse *</label>
                                <input type="date" class="form-control" name="data[wife_birth_date]" value="{{ old('data.wife_birth_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de mariage *</label>
                                <input type="date" class="form-control" name="data[marriage_date]" value="{{ old('data.marriage_date') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lieu de mariage *</label>
                                <input type="text" class="form-control" name="data[marriage_place]" value="{{ old('data.marriage_place') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Death Certificate Form -->
                    <div id="deathForm" class="form-section" style="display: none;">
                        <h5 class="mb-3">Informations sur le défunt</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet du défunt *</label>
                                <input type="text" class="form-control" name="data[deceased_name]" value="{{ old('data.deceased_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de décès *</label>
                                <input type="date" class="form-control" name="data[death_date]" value="{{ old('data.death_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lieu de décès *</label>
                                <input type="text" class="form-control" name="data[death_place]" value="{{ old('data.death_place') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cause du décès</label>
                                <input type="text" class="form-control" name="data[death_cause]" value="{{ old('data.death_cause') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom du déclarant *</label>
                                <input type="text" class="form-control" name="data[declarant_name]" value="{{ old('data.declarant_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lien de parenté *</label>
                                <input type="text" class="form-control" name="data[relationship]" value="{{ old('data.relationship') }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('civil-acts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="bi bi-check-circle"></i> Créer la demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeCards = document.querySelectorAll('.type-card');
    const selectedTypeInput = document.getElementById('selectedType');
    const submitBtn = document.getElementById('submitBtn');
    const formSections = document.querySelectorAll('.form-section');

    typeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            typeCards.forEach(c => c.classList.remove('border-primary', 'bg-light'));
            
            // Add active class to clicked card
            this.classList.add('border-primary', 'bg-light');
            
            // Set the selected type
            const type = this.dataset.type;
            selectedTypeInput.value = type;
            
            // Hide all form sections
            formSections.forEach(section => {
                section.style.display = 'none';
            });
            
            // Show the relevant form section
            const formId = type + 'Form';
            const formSection = document.getElementById(formId);
            if (formSection) {
                formSection.style.display = 'block';
            }
            
            // Enable submit button
            submitBtn.disabled = false;
        });
    });
});
</script>

<style>
.type-card {
    cursor: pointer;
    transition: all 0.2s;
}

.type-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.type-card.border-primary {
    border-width: 2px !important;
}
</style>
@endsection
