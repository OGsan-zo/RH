@extends('layouts.adminlte')

@section('title', 'Voir les tests QCM')
@section('page-title', 'Tests QCM')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tests QCM</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Liste des Tests QCM</h3>
                    <div class="card-tools">
                        <a href="{{ route('tests.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Créer un test
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('tests.view') }}" class="mb-4">
                        <div class="form-group">
                            <label for="annonce_id"><i class="fas fa-filter mr-1"></i>Filtrer par annonce</label>
                            <select name="annonce_id" id="annonce_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Toutes les annonces --</option>
                                @foreach($annonces as $a)
                                    <option value="{{ $a->id }}" {{ $annonceId == $a->id ? 'selected' : '' }}>
                                        {{ $a->titre }} ({{ $a->departement->nom ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    @if($test)
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-check-circle mr-2"></i>{{ $test->titre }}</h3>
                                <div class="card-tools">
                                    <a href="{{ route('tests.delete', $test->id) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Voulez-vous vraiment supprimer définitivement ce test ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted"><i class="fas fa-info-circle mr-1"></i>{{ $test->description }}</p>
                                <hr>
                                
                                @foreach($test->questions as $q)
                                    <div class="callout callout-info mb-3">
                                        <h5><i class="fas fa-question-circle mr-2"></i>Question {{ $loop->iteration }}</h5>
                                        <p class="mb-2"><strong>{{ $q->intitule }}</strong></p>
                                        <ul class="list-unstyled ml-3">
                                            @foreach($q->reponses as $r)
                                                <li class="mb-1">
                                                    @if($r->est_correcte)
                                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                                        <strong class="text-success">{{ $r->texte }}</strong>
                                                        <span class="badge badge-success ml-2">Correcte</span>
                                                    @else
                                                        <i class="far fa-circle text-muted mr-2"></i>
                                                        {{ $r->texte }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($annonceId)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Aucun test généré pour cette annonce.</strong>
                            <br>
                            <a href="{{ route('tests.create') }}" class="alert-link">Cliquez ici pour créer un test</a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Sélectionnez une annonce pour voir son test QCM.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
