@extends('layouts.adminlte')

@section('title', 'Résultats entretiens')
@section('page-title', 'Résultats Globaux')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Résultats Globaux</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Scores Cumulés par Poste</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('evaluations.resultats') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="annonce_id"><i class="fas fa-filter mr-1"></i>Sélectionnez un poste</label>
                                    <select name="annonce_id" id="annonce_id" class="form-control" required>
                                        <option value="">-- Choisir un poste --</option>
                                        @foreach($annonces as $a)
                                            <option value="{{ $a->id }}" @if($posteId == $a->id) selected @endif>
                                                {{ $a->titre }} ({{ $a->departement->nom ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Voir les résultats
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(!empty($candidatures))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Candidat</th>
                                        <th>Poste</th>
                                        <th class="text-center">Score QCM</th>
                                        <th class="text-center">Note Entretien</th>
                                        <th class="text-center">Score Global</th>
                                        <th class="text-center" style="width: 150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatures as $c)
                                        @php
                                            $resultatTest = \App\Models\ResultatTest::where('candidature_id', $c->id)->first();
                                            $evaluation = \App\Models\EvaluationEntretien::whereHas('entretien', function($q) use ($c) {
                                                $q->where('candidature_id', $c->id);
                                            })->first();
                                            $noteEntretienPourcent = $evaluation ? round(($evaluation->note / 20) * 100, 2) : null;
                                        @endphp
                                        <tr>
                                            <td>
                                                <i class="fas fa-user text-muted mr-1"></i>
                                                <strong>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</strong>
                                            </td>
                                            <td>{{ $c->annonce->titre }}</td>
                                            <td class="text-center">
                                                @if($resultatTest)
                                                    @if($resultatTest->score >= 70)
                                                        <span class="badge badge-success">{{ $resultatTest->score }}%</span>
                                                    @elseif($resultatTest->score >= 50)
                                                        <span class="badge badge-warning">{{ $resultatTest->score }}%</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $resultatTest->score }}%</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($evaluation)
                                                    {{ $evaluation->note }}/20
                                                    @if($noteEntretienPourcent >= 70)
                                                        <span class="badge badge-success">({{ $noteEntretienPourcent }}%)</span>
                                                    @elseif($noteEntretienPourcent >= 50)
                                                        <span class="badge badge-warning">({{ $noteEntretienPourcent }}%)</span>
                                                    @else
                                                        <span class="badge badge-danger">({{ $noteEntretienPourcent }}%)</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($c->score_global)
                                                    @if($c->score_global >= 70)
                                                        <span class="badge badge-success badge-lg"><strong>{{ $c->score_global }}%</strong></span>
                                                    @elseif($c->score_global >= 50)
                                                        <span class="badge badge-warning badge-lg"><strong>{{ $c->score_global }}%</strong></span>
                                                    @else
                                                        <span class="badge badge-danger badge-lg"><strong>{{ $c->score_global }}%</strong></span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('decisions.show', $c->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Profil
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Sélectionnez un poste pour voir les résultats des candidats.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
