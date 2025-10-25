@extends('layouts.adminlte')

@section('title', 'Annonces disponibles')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('candidat.dashboard') }}">Accueil</a></li>
    <li class="breadcrumb-item active">Annonces</li>
</ol>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-candidat')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-briefcase mr-2"></i>Liste des Annonces Ouvertes</h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $annonces->count() }} annonce(s)</span>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.alerts')
                    
                    @if($annonces->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Aucune annonce disponible pour le moment.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th><i class="fas fa-briefcase mr-1"></i>Titre</th>
                                        <th><i class="fas fa-building mr-1"></i>Département</th>
                                        <th><i class="fas fa-calendar-times mr-1"></i>Date Limite</th>
                                        <th style="width: 150px;"><i class="fas fa-cogs mr-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($annonces as $a)
                                    <tr>
                                        <td><strong>{{ $a->titre }}</strong></td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <i class="fas fa-building mr-1"></i>{{ $a->departement->nom ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($a->date_limite)->format('d/m/Y') }}
                                            @php
                                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($a->date_limite), false);
                                            @endphp
                                            @if($daysLeft < 0)
                                                <span class="badge badge-danger ml-2">Expirée</span>
                                            @elseif($daysLeft <= 3)
                                                <span class="badge badge-warning ml-2">{{ $daysLeft }} jour(s)</span>
                                            @else
                                                <span class="badge badge-success ml-2">{{ $daysLeft }} jour(s)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('candidatures.show', $a->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye mr-1"></i>Détails
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
