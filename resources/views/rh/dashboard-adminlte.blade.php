@extends('layouts.adminlte')

@section('title', 'Tableau de bord RH')
@section('page-title', 'Tableau de Bord')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <!-- Candidatures -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Candidatures</span>
                    <span class="info-box-number">
                        {{ $stats['candidatures'] ?? 0 }}
                        <small>actives</small>
                    </span>
                </div>
            </div>
        </div>

        <!-- Tests en attente -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tests en attente</span>
                    <span class="info-box-number">{{ $stats['tests'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Entretiens -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Entretiens</span>
                    <span class="info-box-number">{{ $stats['entretiens'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Décisions en attente -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-gavel"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Décisions</span>
                    <span class="info-box-number">{{ $stats['decisions'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des candidatures -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Évolution des Candidatures
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="candidaturesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Répartition par Statut
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="statutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Dernières candidatures -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Dernières Candidatures</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Candidat</th>
                                    <th>Poste</th>
                                    <th>Note CV</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresCandidatures ?? [] as $candidature)
                                <tr>
                                    <td>
                                        <strong>{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</strong>
                                    </td>
                                    <td>{{ Str::limit($candidature->annonce->titre, 30) }}</td>
                                    <td>
                                        @if($candidature->note_cv)
                                            <span class="badge badge-info">{{ $candidature->note_cv }}%</span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($candidature->statut) {
                                                'en_attente' => 'secondary',
                                                'test_en_cours' => 'info',
                                                'en_entretien' => 'warning',
                                                'retenu' => 'success',
                                                'refuse' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucune candidature récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('tri.index') }}" class="btn btn-sm btn-info float-right">Voir toutes les candidatures</a>
                </div>
            </div>
        </div>

        <!-- Prochains entretiens -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Prochains Entretiens</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Candidat</th>
                                    <th>Date</th>
                                    <th>Lieu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prochainsEntretiens ?? [] as $entretien)
                                <tr>
                                    <td>
                                        <strong>{{ $entretien->candidature->candidat->nom }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ \Carbon\Carbon::parse($entretien->date_entretien)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>{{ Str::limit($entretien->lieu, 20) }}</td>
                                    <td>
                                        <a href="{{ route('evaluations.create', $entretien->id) }}" class="btn btn-xs btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun entretien planifié</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('entretiens.create') }}" class="btn btn-sm btn-success float-left">Planifier un entretien</a>
                    <a href="{{ route('entretiens.index') }}" class="btn btn-sm btn-secondary float-right">Voir tous les entretiens</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Actions Rapides
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('annonces.create') }}" class="btn btn-app bg-success">
                                <i class="fas fa-bullhorn"></i> Nouvelle Annonce
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('tri.index') }}" class="btn btn-app bg-info">
                                <i class="fas fa-sort-amount-down"></i> Tri Candidats
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('tests.create') }}" class="btn btn-app bg-warning">
                                <i class="fas fa-clipboard-check"></i> Créer Test
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('resultats.select') }}" class="btn btn-app bg-danger">
                                <span class="badge bg-purple">{{ $stats['decisions'] ?? 0 }}</span>
                                <i class="fas fa-gavel"></i> Décisions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Graphique des candidatures (données réelles)
    const ctxCandidatures = document.getElementById('candidaturesChart').getContext('2d');
    new Chart(ctxCandidatures, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Candidatures',
                data: {!! json_encode($evolutionCandidatures) !!},
                borderColor: 'rgb(52, 152, 219)',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Candidatures: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Graphique des statuts (données réelles)
    const ctxStatut = document.getElementById('statutChart').getContext('2d');
    new Chart(ctxStatut, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statutLabels) !!},
            datasets: [{
                data: {!! json_encode($statutData) !!},
                backgroundColor: {!! json_encode($colors) !!}
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
