@extends('layouts.app')

@section('title', 'Mes Demandes d\'Urbanisme')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-building"></i> Mes Demandes d\'Urbanisme
    </h2>
    <a href="{{ route('urbanisme.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle Demande
    </a>
</div>

@if($urbanismeRequests->count() > 0)
    <div class="row">
        @foreach($urbanismeRequests as $request)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card card-hover h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $request->title }}</h6>
                        <span class="badge 
                            @if($request->status === 'soumis') bg-info
                            @elseif($request->status === 'en_cours') bg-warning
                            @elseif($request->status === 'traite') bg-success
                            @elseif($request->status === 'rejete') bg-danger
                            @endif status-badge">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p>{{ Str::limit($request->description, 100) }}</p>
                        <div class="mb-2">
                            <strong>Créé le:</strong> {{ $request->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('urbanisme.show', $request) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            @if($request->status === 'soumis')
                                <a href="{{ route('urbanisme.edit', $request) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $urbanismeRequests->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-building display-1 text-muted"></i>
        <h3 class="mt-3 text-muted">Aucune demande trouvée</h3>
        <p class="text-muted">Vous n\'avez pas encore créé de demande d\'urbanisme.</p>
        <a href="{{ route('urbanisme.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Créer ma première demande
        </a>
    </div>
@endif
@endsection
