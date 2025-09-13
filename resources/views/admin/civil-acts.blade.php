@extends('layouts.app')

@section('title', 'Gestion des Actes Civils - Administration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gestion des Actes Civils</h1>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" onclick="filterByStatus('all')">Tous</button>
                    <button type="button" class="btn btn-outline-warning" onclick="filterByStatus('pending')">En attente</button>
                    <button type="button" class="btn btn-outline-info" onclick="filterByStatus('in_review')">En examen</button>
                    <button type="button" class="btn btn-outline-success" onclick="filterByStatus('validated')">Validés</button>
                    <button type="button" class="btn btn-outline-danger" onclick="filterByStatus('rejected')">Rejetés</button>
                </div>
            </div>

            <!-- Filtres -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type d'acte</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Tous les types</option>
                                <option value="birth" {{ request('type') == 'birth' ? 'selected' : '' }}>Naissance</option>
                                <option value="marriage" {{ request('type') == 'marriage' ? 'selected' : '' }}>Mariage</option>
                                <option value="death" {{ request('type') == 'death' ? 'selected' : '' }}>Décès</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tous les statuts</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Soumis</option>
                                <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>En attente paiement</option>
                                <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>En examen</option>
                                <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>Validé</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="{{ route('admin.civil-acts') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des actes -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Citoyen</th>
                                    <th>Statut</th>
                                    <th>Paiement</th>
                                    <th>Montant</th>
                                    <th>Date création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($civilActs as $act)
                                <tr>
                                    <td>
                                        <code>{{ $act->reference_number }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            @switch($act->type)
                                                @case('birth') Naissance @break
                                                @case('marriage') Mariage @break
                                                @case('death') Décès @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $act->user->name }}</strong><br>
                                            <small class="text-muted">{{ $act->user->email }}</small>
                                        </div>
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
                                    <td>
                                        @switch($act->payment_status)
                                            @case('pending')
                                                <span class="badge bg-warning">En attente</span>
                                                @break
                                            @case('paid')
                                                <span class="badge bg-success">Payé</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger">Échec</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <strong>{{ number_format($act->amount, 0, ',', ' ') }} XAF</strong>
                                    </td>
                                    <td>
                                        {{ $act->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('civil-acts.show', $act) }}" class="btn btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($act->status === 'in_review')
                                                <form method="POST" action="{{ route('agent.validate', $act) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Valider">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('agent.reject', $act) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger" title="Rejeter">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Aucun acte civil trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($civilActs->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $civilActs->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterByStatus(status) {
    const url = new URL(window.location);
    if (status === 'all') {
        url.searchParams.delete('status');
    } else {
        url.searchParams.set('status', status);
    }
    window.location = url.toString();
}
</script>
@endsection
