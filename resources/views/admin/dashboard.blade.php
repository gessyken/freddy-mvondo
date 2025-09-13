@extends('layouts.app')

@section('title', 'Tableau de Bord - Administration')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-speedometer2"></i> Administration
    </h2>
    <div class="text-muted">
        Bienvenue, {{ auth()->user()->name }}
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['total_citizens'] }}</h3>
                <p class="mb-0">Citoyens</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['total_agents'] }}</h3>
                <p class="mb-0">Agents</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['pending_acts'] }}</h3>
                <p class="mb-0">En attente</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['validated_acts_today'] }}</h3>
                <p class="mb-0">Validés aujourd'hui</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $stats['total_acts_this_month'] }}</h3>
                <p class="mb-0">Ce mois</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ number_format($stats['total_revenue'], 0, ',', ' ') }}</h3>
                <p class="mb-0">Revenus (XAF)</p>
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
                <a href="{{ route('admin.civil-acts') }}" class="btn btn-primary btn-sm">
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
                                    <th>Montant</th>
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
                                                @if($act->status === 'draft') bg-secondary
                                                @elseif($act->status === 'pending_payment') bg-warning
                                                @elseif($act->status === 'under_review') bg-info
                                                @elseif($act->status === 'validated') bg-success
                                                @elseif($act->status === 'rejected') bg-danger
                                                @elseif($act->status === 'ready') bg-success
                                                @endif">
                                                {{ $act->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($act->amount, 0, ',', ' ') }} XAF</td>
                                        <td>{{ $act->created_at->format('d/m/Y H:i') }}</td>
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
                    <a href="{{ route('admin.civil-acts') }}" class="btn btn-primary">
                        <i class="bi bi-file-text"></i> Gérer les actes
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-info">
                        <i class="bi bi-people"></i> Gérer les utilisateurs
                    </a>
                    <a href="{{ route('admin.configuration') }}" class="btn btn-warning">
                        <i class="bi bi-gear"></i> Configuration
                    </a>
                    <a href="{{ route('admin.reports') }}" class="btn btn-success">
                        <i class="bi bi-graph-up"></i> Rapports
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">État du système</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Base de données</span>
                    <span class="badge bg-success">Opérationnelle</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Paiements</span>
                    <span class="badge bg-success">Actifs</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Notifications</span>
                    <span class="badge bg-success">Actives</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Stockage</span>
                    <span class="badge bg-warning">75% utilisé</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Activité récente</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Acte validé</h6>
                            <p class="timeline-text">ACT-2024-123456</p>
                            <small class="text-muted">Il y a 2 heures</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Nouvelle demande</h6>
                            <p class="timeline-text">Acte de naissance</p>
                            <small class="text-muted">Il y a 4 heures</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Paiement reçu</h6>
                            <p class="timeline-text">15 000 XAF</p>
                            <small class="text-muted">Il y a 6 heures</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 15px;
}

.timeline-title {
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.timeline-text {
    margin-bottom: 5px;
    font-size: 0.8rem;
    color: #6c757d;
}
</style>
@endsection
