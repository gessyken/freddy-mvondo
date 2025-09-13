@extends('layouts.app')

@section('title', 'Rapports et Statistiques - Administration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Rapports et Statistiques</h1>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" onclick="exportReport('csv')">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="exportReport('pdf')">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Période de rapport -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="period" class="form-label">Période</label>
                            <select class="form-select" id="period" name="period" onchange="updateDateInputs()">
                                <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Ce mois</option>
                                <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Mois dernier</option>
                                <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Cette année</option>
                                <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Période personnalisée</option>
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
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Générer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistiques générales -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['total_acts'] }}</h4>
                                    <p class="card-text">Total des actes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['validated_acts'] }}</h4>
                                    <p class="card-text">Actes validés</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $stats['pending_acts'] }}</h4>
                                    <p class="card-text">En attente</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XAF</h4>
                                    <p class="card-text">Revenus totaux</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Répartition par type -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Répartition par type d'acte</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="typeChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Répartition par statut -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Répartition par statut</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Évolution des revenus -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Évolution des revenus mensuels</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau détaillé -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Détail des actes par mois</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Naissances</th>
                                            <th>Mariages</th>
                                            <th>Décès</th>
                                            <th>Total</th>
                                            <th>Revenus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($monthlyData as $month => $data)
                                        <tr>
                                            <td><strong>{{ $month }}</strong></td>
                                            <td>{{ $data['birth'] ?? 0 }}</td>
                                            <td>{{ $data['marriage'] ?? 0 }}</td>
                                            <td>{{ $data['death'] ?? 0 }}</td>
                                            <td><strong>{{ $data['total'] ?? 0 }}</strong></td>
                                            <td><strong>{{ number_format($data['revenue'] ?? 0, 0, ',', ' ') }} XAF</strong></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Aucune donnée disponible
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuration des graphiques
const typeData = @json($typeStats);
const statusData = @json($statusStats);
const revenueData = @json($revenueStats);

// Graphique des types
const typeCtx = document.getElementById('typeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(typeData),
        datasets: [{
            data: Object.values(typeData),
            backgroundColor: ['#007bff', '#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Graphique des statuts
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(statusData),
        datasets: [{
            label: 'Nombre d\'actes',
            data: Object.values(statusData),
            backgroundColor: ['#6c757d', '#007bff', '#ffc107', '#17a2b8', '#28a745', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Graphique des revenus
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: Object.keys(revenueData),
        datasets: [{
            label: 'Revenus (XAF)',
            data: Object.values(revenueData),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + ' XAF';
                    }
                }
            }
        }
    }
});

function updateDateInputs() {
    const period = document.getElementById('period').value;
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    switch(period) {
        case 'this_month':
            dateFrom.value = firstDay.toISOString().split('T')[0];
            dateTo.value = lastDay.toISOString().split('T')[0];
            break;
        case 'last_month':
            const lastMonthFirst = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastMonthLast = new Date(today.getFullYear(), today.getMonth(), 0);
            dateFrom.value = lastMonthFirst.toISOString().split('T')[0];
            dateTo.value = lastMonthLast.toISOString().split('T')[0];
            break;
        case 'this_year':
            const yearFirst = new Date(today.getFullYear(), 0, 1);
            const yearLast = new Date(today.getFullYear(), 11, 31);
            dateFrom.value = yearFirst.toISOString().split('T')[0];
            dateTo.value = yearLast.toISOString().split('T')[0];
            break;
    }
}

function exportReport(format) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', format);
    window.location.href = '{{ route("admin.reports") }}?' + params.toString();
}

// Initialiser les dates
updateDateInputs();
</script>
@endsection
