@extends('layouts.app')

@section('title', 'Détails de la Demande - ' . $urbanismeRequest->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-building"></i> Détails de la Demande
    </h2>
    <div>
        <span class="badge 
            @if($urbanismeRequest->status === 'soumis') bg-info
            @elseif($urbanismeRequest->status === 'en_cours') bg-warning
            @elseif($urbanismeRequest->status === 'traite') bg-success
            @elseif($urbanismeRequest->status === 'rejete') bg-danger
            @endif fs-6">
            {{ ucfirst(str_replace('_', ' ', $urbanismeRequest->status)) }}
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ $urbanismeRequest->title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $urbanismeRequest->description }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Créé le:</strong> {{ $urbanismeRequest->created_at->format('d/m/Y à H:i') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Dernière mise à jour:</strong> {{ $urbanismeRequest->updated_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
                @if($urbanismeRequest->latitude && $urbanismeRequest->longitude)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Latitude:</strong> {{ $urbanismeRequest->latitude }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Longitude:</strong> {{ $urbanismeRequest->longitude }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($urbanismeRequest->photo_path)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Photo</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $urbanismeRequest->photo_path) }}" class="img-fluid rounded" alt="Photo de la demande">
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('urbanisme.edit', $urbanismeRequest) }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
                <form method="POST" action="{{ route('urbanisme.destroy', $urbanismeRequest) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
