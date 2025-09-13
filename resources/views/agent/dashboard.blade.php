@extends('layouts.app')

@section('title', 'Tableau de Bord - Agent')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-speedometer2"></i> Tableau de Bord
    </h2>
    <div class="text-muted">
        Bienvenue, {{ auth()->user()->name }}
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['pending_review'] }}</h4>
                        <p class="mb-0">En attente d'examen</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock-history display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['validated_today'] }}</h4>
                        <p class="mb-0">Validés aujourd'hui</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['rejected_today'] }}</h4>
                        <p class="mb-0">Rejetés aujourd'hui</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-x-circle display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_this_month'] }}</h4>
                        <p class="mb-0">Total ce mois</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-text display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Acts -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Actes récents</h5>
                <a href="{{ route('agent.pending-review') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-list-ul"></i> Voir tous
                </a>
            </div>
            <div class="card-body">
                @if($recentActs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Citoyen</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActs as $act)
                                    <tr>
                                        <td>
                                            <code>{{ $act->reference_number }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $act->type_label }}</span>
                                        </td>
                                        <td>{{ $act->user->name }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($act->status === 'under_review') bg-info
                                                @elseif($act->status === 'validated') bg-success
                                                @elseif($act->status === 'rejected') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ $act->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $act->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('civil-acts.show', $act) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted"></i>
                        <p class="text-muted mt-2">Aucun acte récent</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('agent.pending-review') }}" class="btn btn-warning">
                        <i class="bi bi-clock-history"></i> Examiner les demandes
                    </a>
                    <a href="{{ route('civil-acts.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list-ul"></i> Tous les actes
                    </a>
                    <a href="{{ route('public.verify') }}" class="btn btn-outline-success">
                        <i class="bi bi-shield-check"></i> Vérifier un acte
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Notifications</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>{{ $stats['pending_review'] }}</strong> demande(s) en attente d'examen.
                </div>
                @if($stats['pending_review'] > 0)
                    <a href="{{ route('agent.pending-review') }}" class="btn btn-warning btn-sm w-100">
                        Commencer l'examen
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
