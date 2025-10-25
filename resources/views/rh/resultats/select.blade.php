@extends('layouts.adminlte')

@section('title', 'Résultats des candidats')
@section('page-title', 'Résultats QCM')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Résultats QCM</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Résultats des Tests QCM</h3>
                </div>
                <div class="card-body">
                    @if($resultats->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Aucun test passé pour le moment.</strong>
                            <br>
                            Les résultats apparaîtront ici une fois que les candidats auront passé leurs tests.
                        </div>
                    @else
                        <form method="GET" action="" onsubmit="return allerVersResultat()">
                            <div class="form-group">
                                <label for="resultSelect"><i class="fas fa-user-graduate mr-1"></i>Sélectionnez un candidat</label>
                                <select id="resultSelect" class="form-control" required>
                                    <option value="">-- Choisir un candidat --</option>
                                    @foreach($resultats as $r)
                                        <option value="{{ route('resultats.details', $r->candidature_id) }}">
                                            {{ $r->candidature->candidat->nom }} {{ $r->candidature->candidat->prenom }}
                                            — {{ $r->test->titre }}
                                            @if($r->score >= 70)
                                                <span style="color: green;">({{ $r->score }}% ✓)</span>
                                            @elseif($r->score >= 50)
                                                <span style="color: orange;">({{ $r->score }}%)</span>
                                            @else
                                                <span style="color: red;">({{ $r->score }}%)</span>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> {{ $resultats->count() }} résultat(s) disponible(s)
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-eye"></i> Voir le résultat détaillé
                            </button>
                        </form>

                        <hr>

                        <div class="info-box bg-light mt-3">
                            <span class="info-box-icon bg-info"><i class="fas fa-info-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Légende des scores</span>
                                <span class="info-box-number">
                                    <span class="text-success">≥ 70% : Excellent</span> | 
                                    <span class="text-warning">50-69% : Moyen</span> | 
                                    <span class="text-danger">&lt; 50% : Faible</span>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function allerVersResultat() {
    const url = document.getElementById('resultSelect').value;
    if (url) {
        window.location.href = url;
    }
    return false;
}
</script>
@endpush
