@extends('layouts.adminlte')

@section('title', 'Affiliations sociales')
@section('page-title', 'Affiliations Sociales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Affiliations</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Liste des Affiliations Sociales</h3>
                    <div class="card-tools">
                        <a href="{{ route('affiliations.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle affiliation
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($affiliations->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucune affiliation enregistrée.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Employé</th>
                                        <th>Poste</th>
                                        <th>Organisme</th>
                                        <th>Numéro</th>
                                        <th class="text-center">Taux (%)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($affiliations as $a)
                                    <tr>
                                        <td><i class="fas fa-user text-muted mr-1"></i>{{ $a->contrat->candidature->candidat->nom }} {{ $a->contrat->candidature->candidat->prenom }}</td>
                                        <td>{{ $a->contrat->candidature->annonce->titre }}</td>
                                        <td>
                                            @if($a->organisme === 'CNAPS')
                                                <span class="badge badge-primary">{{ $a->organisme }}</span>
                                            @elseif($a->organisme === 'OSTIE')
                                                <span class="badge badge-success">{{ $a->organisme }}</span>
                                            @else
                                                <span class="badge badge-info">{{ $a->organisme }}</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $a->numero_affiliation }}</code></td>
                                        <td class="text-center"><strong>{{ $a->taux_cotisation }}%</strong></td>
                                        <td><i class="far fa-calendar text-muted mr-1"></i>{{ \Carbon\Carbon::parse($a->date_affiliation)->format('d/m/Y') }}</td>
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
