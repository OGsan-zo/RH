@extends('layouts.adminlte')

@section('title', 'Promotions')
@section('page-title', 'Promotions')

@section('breadcrumb')
    <li class="breadcrumb-item active">Promotions</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestion des Promotions</h3>
            <div class="card-tools">
                <a href="{{ route('promotions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle Promotion
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($promotions->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Aucune promotion enregistrée.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Ancien Poste</th>
                                <th>Nouveau Poste</th>
                                <th>Ancien Salaire</th>
                                <th>Nouveau Salaire</th>
                                <th>Date Effet</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $promotion)
                                <tr>
                                    <td><strong>{{ $promotion->employe->candidat->nom ?? 'N/A' }}</strong></td>
                                    <td>{{ $promotion->ancienPoste->titre ?? '-' }}</td>
                                    <td>{{ $promotion->nouveauPoste->titre ?? '-' }}</td>
                                    <td>{{ $promotion->ancien_salaire ? number_format($promotion->ancien_salaire, 2) . ' €' : '-' }}</td>
                                    <td><span class="badge badge-success">{{ number_format($promotion->nouveau_salaire, 2) }} €</span></td>
                                    <td>{{ \Carbon\Carbon::parse($promotion->date_effet)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-warning btn-xs">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('promotions.delete', $promotion->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash"></i>
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
@endsection
