@extends('layouts.app')

@section('title', 'Détails Utilisateur - Administration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Détails de l'Utilisateur</h1>
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Informations générales -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informations générales</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nom :</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email :</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Téléphone :</strong></td>
                                    <td>{{ $user->phone ?? 'Non renseigné' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Rôle :</strong></td>
                                    <td>
                                        @switch($user->role)
                                            @case('citizen')
                                                <span class="badge bg-primary">Citoyen</span>
                                                @break
                                            @case('agent')
                                                <span class="badge bg-info">Agent</span>
                                                @break
                                            @case('admin')
                                                <span class="badge bg-danger">Administrateur</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Statut :</strong></td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Membre depuis :</strong></td>
                                    <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                @if($user->last_login_at)
                                <tr>
                                    <td><strong>Dernière connexion :</strong></td>
                                    <td>{{ $user->last_login_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Statistiques</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-primary mb-1">{{ $user->civilActs->count() }}</h3>
                                        <small class="text-muted">Actes créés</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-success mb-1">{{ $user->civilActs->where('status', 'validated')->count() }}</h3>
                                        <small class="text-muted">Actes validés</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-warning mb-1">{{ $user->civilActs->whereIn('status', ['submitted', 'in_review'])->count() }}</h3>
                                        <small class="text-muted">En attente</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-info mb-1">{{ number_format($user->civilActs->where('payment_status', 'paid')->sum('amount'), 0, ',', ' ') }}</h3>
                                        <small class="text-muted">XAF payés</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Modifier l'utilisateur
                                </a>
                                
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                            {{ $user->is_active ? 'Désactiver' : 'Activer' }} l'utilisateur
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="mailto:{{ $user->email }}" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope"></i> Envoyer un email
                                </a>
                                
                                @if($user->phone)
                                    <a href="tel:{{ $user->phone }}" class="btn btn-outline-info">
                                        <i class="fas fa-phone"></i> Appeler
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique des actes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Actes récents de cet utilisateur</h5>
                        </div>
                        <div class="card-body">
                            @if($user->civilActs->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Référence</th>
                                                <th>Type</th>
                                                <th>Statut</th>
                                                <th>Montant</th>
                                                <th>Date création</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->civilActs as $act)
                                            <tr>
                                                <td><code>{{ $act->reference_number }}</code></td>
                                                <td>
                                                    @switch($act->type)
                                                        @case('birth') Naissance @break
                                                        @case('marriage') Mariage @break
                                                        @case('death') Décès @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @switch($act->status)
                                                        @case('draft')
                                                            <span class="badge bg-secondary">Brouillon</span>
                                                            @break
                                                        @case('submitted')
                                                            <span class="badge bg-primary">Soumis</span>
                                                            @break
                                                        @case('pending_payment')
                                                            <span class="badge bg-warning">En attente paiement</span>
                                                            @break
                                                        @case('in_review')
                                                            <span class="badge bg-info">En examen</span>
                                                            @break
                                                        @case('validated')
                                                            <span class="badge bg-success">Validé</span>
                                                            @break
                                                        @case('rejected')
                                                            <span class="badge bg-danger">Rejeté</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>{{ number_format($act->amount, 0, ',', ' ') }} XAF</td>
                                                <td>{{ $act->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('civil-acts.show', $act) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-file-alt fa-3x mb-3"></i>
                                    <p>Aucun acte créé par cet utilisateur</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
