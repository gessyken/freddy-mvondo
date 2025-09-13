@extends('layouts.app')

@section('title', 'Mes Demandes d\'Actes Civils')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-list-ul"></i> Mes Demandes d'Actes Civils
    </h2>
    <a href="{{ route('civil-acts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle Demande
    </a>
</div>

@if($civilActs->count() > 0)
    <div class="row">
        @foreach($civilActs as $civilAct)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $civilAct->type_label }}</h6>
                        <span class="badge 
                            @if($civilAct->status === 'draft') bg-secondary
                            @elseif($civilAct->status === 'pending_payment') bg-warning
                            @elseif($civilAct->status === 'under_review') bg-info
                            @elseif($civilAct->status === 'validated') bg-success
                            @elseif($civilAct->status === 'rejected') bg-danger
                            @elseif($civilAct->status === 'ready') bg-success
                            @endif status-badge">
                            {{ $civilAct->status_label }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <strong>Référence:</strong> {{ $civilAct->reference_number }}
                        </div>
                        <div class="mb-2">
                            <strong>Montant:</strong> {{ number_format($civilAct->amount, 0, ',', ' ') }} XAF
                        </div>
                        <div class="mb-2">
                            <strong>Créé le:</strong> {{ $civilAct->created_at->format('d/m/Y H:i') }}
                        </div>
                        @if($civilAct->submitted_at)
                            <div class="mb-2">
                                <strong>Soumis le:</strong> {{ $civilAct->submitted_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if($civilAct->validated_at)
                            <div class="mb-2">
                                <strong>Validé le:</strong> {{ $civilAct->validated_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if($civilAct->rejection_reason)
                            <div class="mb-2">
                                <strong>Motif de rejet:</strong> 
                                <span class="text-danger">{{ Str::limit($civilAct->rejection_reason, 50) }}</span>
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $civilAct->documents->count() }} document(s)
                                </small>
                                @if($civilAct->messages->count() > 0)
                                    <small class="text-info">
                                        <i class="bi bi-chat-dots"></i> {{ $civilAct->messages->count() }} message(s)
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('civil-acts.show', $civilAct) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            @if($civilAct->status === 'draft')
                                <a href="{{ route('civil-acts.edit', $civilAct) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                            @endif
                            @if($civilAct->status === 'pending_payment')
                                <a href="{{ route('payments.create', $civilAct) }}" class="btn btn-success btn-sm flex-fill">
                                    <i class="bi bi-credit-card"></i> Payer
                                </a>
                            @endif
                            @if($civilAct->status === 'ready' && $civilAct->pdf_path)
                                <a href="{{ route('public.download-act', $civilAct) }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-download"></i> Télécharger
                                </a>
                            @endif
                        </div>
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
        <i class="bi bi-file-text display-1 text-muted"></i>
        <h3 class="mt-3 text-muted">Aucune demande trouvée</h3>
        <p class="text-muted">Vous n'avez pas encore créé de demande d'acte civil.</p>
        <a href="{{ route('civil-acts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Créer ma première demande
        </a>
    </div>
@endif
@endsection
