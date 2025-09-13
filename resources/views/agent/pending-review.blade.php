@extends('layouts.app')

@section('title', 'Demandes en Attente d\'Examen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-clock-history"></i> Demandes en Attente d'Examen
    </h2>
    <div class="text-muted">
        {{ $civilActs->total() }} demande(s) trouvée(s)
    </div>
</div>

@if($civilActs->count() > 0)
    <div class="row">
        @foreach($civilActs as $civilAct)
            <div class="col-lg-6 mb-4">
                <div class="card card-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $civilAct->type_label }}</h6>
                            <small class="text-muted">{{ $civilAct->reference_number }}</small>
                        </div>
                        <span class="badge bg-info">{{ $civilAct->status_label }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>Citoyen:</strong><br>
                                {{ $civilAct->user->name }}
                            </div>
                            <div class="col-6">
                                <strong>Montant:</strong><br>
                                {{ number_format($civilAct->amount, 0, ',', ' ') }} XAF
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <strong>Soumis le:</strong><br>
                                {{ $civilAct->submitted_at ? $civilAct->submitted_at->format('d/m/Y H:i') : 'Non soumis' }}
                            </div>
                            <div class="col-6">
                                <strong>Documents:</strong><br>
                                {{ $civilAct->documents->count() }} document(s)
                            </div>
                        </div>

                        @if($civilAct->documents->count() > 0)
                            <div class="mb-3">
                                <strong>Documents fournis:</strong>
                                <div class="mt-1">
                                    @foreach($civilAct->documents as $document)
                                        <span class="badge 
                                            @if($document->is_validated) bg-success
                                            @elseif($document->is_required) bg-warning
                                            @else bg-secondary
                                            @endif me-1 mb-1">
                                            {{ $document->name }}
                                            @if($document->is_required)
                                                <i class="bi bi-exclamation-triangle"></i>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($civilAct->messages->count() > 0)
                            <div class="mb-3">
                                <strong>Messages:</strong>
                                <div class="mt-1">
                                    <span class="badge bg-info">
                                        <i class="bi bi-chat-dots"></i> {{ $civilAct->messages->count() }} message(s)
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('civil-acts.show', $civilAct) }}" class="btn btn-primary btn-sm flex-fill">
                                <i class="bi bi-eye"></i> Examiner
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('civil-acts.show', $civilAct) }}">
                                            <i class="bi bi-eye"></i> Voir les détails
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#validateModal{{ $civilAct->id }}">
                                            <i class="bi bi-check-circle"></i> Valider
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $civilAct->id }}">
                                            <i class="bi bi-x-circle"></i> Rejeter
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#requestDocumentsModal{{ $civilAct->id }}">
                                            <i class="bi bi-file-earmark-plus"></i> Demander des documents
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validation Modal -->
            <div class="modal fade" id="validateModal{{ $civilAct->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Valider la demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('agent.validate', $civilAct) }}">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="action" value="validate">
                                <p>Êtes-vous sûr de vouloir valider cette demande ?</p>
                                <div class="mb-3">
                                    <label class="form-label">Notes (optionnel)</label>
                                    <textarea class="form-control" name="notes" rows="3" 
                                              placeholder="Ajoutez des notes sur la validation..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Rejection Modal -->
            <div class="modal fade" id="rejectModal{{ $civilAct->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Rejeter la demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('agent.validate', $civilAct) }}">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="action" value="reject">
                                <p>Veuillez indiquer la raison du rejet :</p>
                                <div class="mb-3">
                                    <label class="form-label">Motif de rejet *</label>
                                    <textarea class="form-control" name="notes" rows="3" 
                                              placeholder="Expliquez pourquoi cette demande est rejetée..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Rejeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Request Documents Modal -->
            <div class="modal fade" id="requestDocumentsModal{{ $civilAct->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Demander des documents supplémentaires</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="{{ route('agent.request-documents', $civilAct) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Documents requis *</label>
                                    <div class="row">
                                        @if($civilAct->type === 'birth')
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="birth_declaration" id="birth_declaration">
                                                    <label class="form-check-label" for="birth_declaration">Déclaration de naissance</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="parent_id_copy" id="parent_id_copy">
                                                    <label class="form-check-label" for="parent_id_copy">CNI des parents</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="witness_id_copy" id="witness_id_copy">
                                                    <label class="form-check-label" for="witness_id_copy">CNI des témoins</label>
                                                </div>
                                            </div>
                                        @elseif($civilAct->type === 'marriage')
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="spouse_birth_certificate" id="spouse_birth_certificate">
                                                    <label class="form-check-label" for="spouse_birth_certificate">Acte de naissance des époux</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="spouse_id_copy" id="spouse_id_copy">
                                                    <label class="form-check-label" for="spouse_id_copy">CNI des époux</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="celibacy_certificate" id="celibacy_certificate">
                                                    <label class="form-check-label" for="celibacy_certificate">Certificat de célibat</label>
                                                </div>
                                            </div>
                                        @elseif($civilAct->type === 'death')
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="death_declaration" id="death_declaration">
                                                    <label class="form-check-label" for="death_declaration">Déclaration de décès</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="declarant_id_copy" id="declarant_id_copy">
                                                    <label class="form-check-label" for="declarant_id_copy">CNI du déclarant</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="document_types[]" value="witness_id_copy" id="witness_id_copy_death">
                                                    <label class="form-check-label" for="witness_id_copy_death">CNI des témoins</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message *</label>
                                    <textarea class="form-control" name="message" rows="3" 
                                              placeholder="Expliquez quels documents sont requis..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-warning">Envoyer la demande</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $civilActs->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-check-circle display-1 text-success"></i>
        <h3 class="mt-3 text-success">Aucune demande en attente</h3>
        <p class="text-muted">Toutes les demandes ont été traitées. Excellent travail !</p>
        <a href="{{ route('civil-acts.index') }}" class="btn btn-primary">
            <i class="bi bi-list-ul"></i> Voir tous les actes
        </a>
    </div>
@endif
@endsection
