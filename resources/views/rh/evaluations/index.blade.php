@extends('layouts.adminlte')

@section('title', 'Évaluation entretiens')
@section('page-title', 'Évaluation des Entretiens')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Évaluations</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>Entretiens Confirmés à Évaluer</h3>
                </div>
                <div class="card-body">
                    @if($entretiensConfirmes->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Aucun entretien confirmé à évaluer pour le moment.</strong>
                            <br>
                            Les entretiens confirmés apparaîtront ici pour évaluation.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Candidat</th>
                                        <th>Poste</th>
                                        <th>Date Entretien</th>
                                        <th>Lieu</th>
                                        <th class="text-center" style="width: 150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entretiensConfirmes as $e)
                                    <tr>
                                        <td>
                                            <i class="fas fa-user text-muted mr-1"></i>
                                            <strong>{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}</strong>
                                        </td>
                                        <td>{{ $e->candidature->annonce->titre }}</td>
                                        <td>
                                            <i class="far fa-calendar text-muted mr-1"></i>
                                            {{ \Carbon\Carbon::parse($e->date_entretien)->format('d/m/Y H:i') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-muted mr-1"></i>
                                            {{ $e->lieu }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('evaluations.create', $e->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-star"></i> Évaluer
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
