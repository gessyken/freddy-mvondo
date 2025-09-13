@extends('layouts.app')

@section('title', 'Détails de la Demande - ' . $civilAct->reference_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-file-text"></i> {{ $civilAct->type_label }}
        <small class="text-muted">- {{ $civilAct->reference_number }}</small>
    </h2>
    <div>
        <span class="badge 
            @if($civilAct->status === 'draft') bg-secondary
            @elseif($civilAct->status === 'pending_payment') bg-warning
            @elseif($civilAct->status === 'under_review') bg-info
            @elseif($civilAct->status === 'validated') bg-success
            @elseif($civilAct->status === 'rejected') bg-danger
            @elseif($civilAct->status === 'ready') bg-success
            @endif fs-6">
            {{ $civilAct->status_label }}
        </span>
    </div>
</div>

<div class="row">
    <!-- Main Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informations de la demande</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Type d'acte:</strong> {{ $civilAct->type_label }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Montant:</strong> {{ number_format($civilAct->amount, 0, ',', ' ') }} XAF
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Statut du paiement:</strong>
                        <span class="badge 
                            @if($civilAct->payment_status === 'paid') bg-success
                            @elseif($civilAct->payment_status === 'pending') bg-warning
                            @else bg-danger
                            @endif">
                            {{ ucfirst($civilAct->payment_status) }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Créé le:</strong> {{ $civilAct->created_at->format('d/m/Y à H:i') }}
                    </div>
                    @if($civilAct->submitted_at)
                        <div class="col-md-6 mb-3">
                            <strong>Soumis le:</strong> {{ $civilAct->submitted_at->format('d/m/Y à H:i') }}
                        </div>
                    @endif
                    @if($civilAct->validated_at)
                        <div class="col-md-6 mb-3">
                            <strong>Validé le:</strong> {{ $civilAct->validated_at->format('d/m/Y à H:i') }}
                        </div>
                    @endif
                    @if($civilAct->rejected_at)
                        <div class="col-md-6 mb-3">
                            <strong>Rejeté le:</strong> {{ $civilAct->rejected_at->format('d/m/Y à H:i') }}
                        </div>
                    @endif
                </div>

                @if($civilAct->rejection_reason)
                    <div class="alert alert-danger">
                        <strong>Motif de rejet:</strong> {{ $civilAct->rejection_reason }}
                    </div>
                @endif

                <!-- Form Data Display -->
                <div class="mt-4">
                    <h6>Détails de la demande:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            @foreach($civilAct->data as $key => $value)
                                <tr>
                                    <td class="fw-bold">{{ ucfirst(str_replace('_', ' ', $key)) }}:</td>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Documents</h5>
                @if($civilAct->status === 'draft')
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="bi bi-upload"></i> Ajouter un document
                    </button>
                @endif
            </div>
            <div class="card-body">
                @if($civilAct->documents->count() > 0)
                    <div class="row">
                        @foreach($civilAct->documents as $document)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title">{{ $document->name }}</h6>
                                                <p class="card-text small text-muted">
                                                    {{ $document->file_size_human }} - {{ $document->mime_type }}
                                                </p>
                                                @if($document->is_required)
                                                    <span class="badge bg-warning">Requis</span>
                                                @endif
                                                @if($document->is_validated)
                                                    <span class="badge bg-success">Validé</span>
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('documents.download', [$civilAct, $document]) }}">
                                                            <i class="bi bi-download"></i> Télécharger
                                                        </a>
                                                    </li>
                                                    @if($civilAct->status === 'draft')
                                                        <li>
                                                            <form method="POST" action="{{ route('documents.destroy', [$civilAct, $document]) }}" 
                                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash"></i> Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @if($document->validation_notes)
                                            <div class="mt-2">
                                                <small class="text-info">
                                                    <i class="bi bi-info-circle"></i> {{ $document->validation_notes }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted"></i>
                        <p class="text-muted mt-2">Aucun document téléchargé</p>
                        @if($civilAct->status === 'draft')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <i class="bi bi-upload"></i> Ajouter un document
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Messages Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Messages</h5>
            </div>
            <div class="card-body">
                <div id="messagesContainer" style="max-height: 400px; overflow-y: auto;">
                    @foreach($civilAct->messages as $message)
                        <div class="message-item mb-3 p-3 rounded 
                            @if($message->sender_id === auth()->id()) bg-primary text-white
                            @else bg-light
                            @endif">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $message->sender->name }}</strong>
                                    <small class="opacity-75">
                                        ({{ $message->created_at->format('d/m/Y H:i') }})
                                    </small>
                                </div>
                                <span class="badge bg-secondary">{{ $message->type_label }}</span>
                            </div>
                            <div class="mt-2">{{ $message->message }}</div>
                        </div>
                    @endforeach
                </div>

                @if($civilAct->status !== 'draft')
                    <form method="POST" action="{{ route('messages.store', $civilAct) }}" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <select name="message_type" class="form-select" style="max-width: 200px;">
                                <option value="general">Général</option>
                                <option value="document_request">Demande de document</option>
                                <option value="status_update">Mise à jour de statut</option>
                            </select>
                            <textarea name="message" class="form-control" rows="2" 
                                      placeholder="Tapez votre message..." required></textarea>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                @if($civilAct->status === 'draft')
                    <a href="{{ route('civil-acts.edit', $civilAct) }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <form method="POST" action="{{ route('civil-acts.submit', $civilAct) }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir soumettre cette demande ?')">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-send"></i> Soumettre
                        </button>
                    </form>
                @endif

                @if($civilAct->status === 'pending_payment')
                    <a href="{{ route('payments.create', $civilAct) }}" class="btn btn-success w-100 mb-2">
                        <i class="bi bi-credit-card"></i> Effectuer le paiement
                    </a>
                @endif

                @if($civilAct->status === 'ready' && $civilAct->pdf_path)
                    <a href="{{ route('public.download-act', $civilAct) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-download"></i> Télécharger l'acte
                    </a>
                @endif

                @if($civilAct->status === 'draft')
                    <form method="POST" action="{{ route('civil-acts.destroy', $civilAct) }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Payment History -->
        @if($civilAct->payments->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Historique des paiements</h5>
                </div>
                <div class="card-body">
                    @foreach($civilAct->payments as $payment)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <small class="text-muted">{{ $payment->method_label }}</small>
                                <br>
                                <strong>{{ number_format($payment->amount, 0, ',', ' ') }} XAF</strong>
                            </div>
                            <span class="badge 
                                @if($payment->status === 'success') bg-success
                                @elseif($payment->status === 'pending') bg-warning
                                @else bg-danger
                                @endif">
                                {{ $payment->status_label }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
@if($civilAct->status === 'draft')
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('documents.store', $civilAct) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom du document</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type de document</label>
                            <select class="form-select" name="type" required>
                                <option value="">Sélectionner le type</option>
                                @if($civilAct->type === 'birth')
                                    <option value="birth_declaration">Déclaration de naissance</option>
                                    <option value="parent_id_copy">CNI des parents</option>
                                    <option value="witness_id_copy">CNI des témoins</option>
                                @elseif($civilAct->type === 'marriage')
                                    <option value="spouse_birth_certificate">Acte de naissance des époux</option>
                                    <option value="spouse_id_copy">CNI des époux</option>
                                    <option value="celibacy_certificate">Certificat de célibat</option>
                                    <option value="domicile_certificate">Certificat de domicile</option>
                                    <option value="witness_id_copy">CNI des témoins</option>
                                    <option value="photos">Photos</option>
                                @elseif($civilAct->type === 'death')
                                    <option value="death_declaration">Déclaration de décès</option>
                                    <option value="declarant_id_copy">CNI du déclarant</option>
                                    <option value="witness_id_copy">CNI des témoins</option>
                                    <option value="marriage_certificate_copy">Acte de mariage</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fichier</label>
                            <input type="file" class="form-control" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Formats acceptés: PDF, JPG, PNG (max 10MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Télécharger</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
