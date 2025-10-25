@extends('layouts.adminlte')

@section('title', 'Sélection du test')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Tests QCM</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    @include('layouts.alerts')

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>Choisir un Test à Passer</h3>
                </div>
                <div class="card-body">
                    @if($candidatures->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Aucune candidature éligible pour un test.
                        </div>
                        <a href="{{ route('candidatures.index') }}" class="btn btn-primary">
                            <i class="fas fa-briefcase mr-2"></i>Voir les annonces disponibles
                        </a>
                    @else
                        <form method="GET" action="" onsubmit="return redirigerVersTest()">
                            <div class="form-group">
                                <label for="annonceSelect">
                                    <i class="fas fa-briefcase mr-2"></i>Choisir un poste :
                                </label>
                                <select id="annonceSelect" class="form-control select2" required>
                                    <option value="">-- Sélectionner un poste --</option>
                                    @foreach($candidatures as $c)
                                        @php
                                            $test = \App\Models\Test::where('annonce_id', $c->annonce_id)->first();
                                        @endphp
                                        @if($test)
                                            <option value="{{ route('tests.passer', $test->id) }}">
                                                {{ $c->annonce->titre }} — {{ $c->annonce->departement->nom ?? '' }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="callout callout-info">
                                <h5><i class="fas fa-info-circle"></i> Informations importantes :</h5>
                                <ul class="mb-0">
                                    <li>Assurez-vous d'avoir une connexion internet stable</li>
                                    <li>Le test doit être complété en une seule session</li>
                                    <li>Lisez attentivement chaque question avant de répondre</li>
                                    <li>Vous ne pourrez pas revenir en arrière après validation</li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-play mr-2"></i>Passer le test
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('candidat.dashboard') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i>Retour
                                    </a>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function redirigerVersTest() {
    const url = document.getElementById('annonceSelect').value;
    if (url) {
        window.location.href = url;
    }
    return false;
}
</script>
@endpush
