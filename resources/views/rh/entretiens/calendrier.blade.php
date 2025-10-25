@extends('layouts.adminlte')

@section('title', 'Calendrier des entretiens')
@section('page-title', 'Calendrier des Entretiens')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('rh.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('entretiens.index') }}">Entretiens</a></li>
    <li class="breadcrumb-item active">Calendrier</li>
@endsection

@section('sidebar')
    @include('layouts.partials.sidebar-rh')
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Calendrier Interactif</h3>
                    <div class="card-tools">
                        <a href="{{ route('entretiens.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-list"></i> Vue liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour planifier -->
    <div class="modal fade" id="entretienModal" tabindex="-1" aria-labelledby="entretienModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="entretienModalLabel">
                        <i class="fas fa-calendar-plus mr-2"></i>Planifier un Entretien
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEntretien" method="POST" action="{{ route('entretiens.create') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="date_entretien" id="date_entretien">

                        <div class="callout callout-info">
                            <p class="mb-0"><strong>Seuil actuel :</strong> {{ $hasSeuil ? number_format($seuil,2) : 'N/A' }}%</p>
                        </div>

                        @unless($hasSeuil)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Aucun score QCM disponible. La liste des candidats éligibles est vide.
                            </div>
                        @endunless

                        <div class="form-group">
                            <label for="candidature_id"><i class="fas fa-user mr-1"></i>Candidat <span class="text-danger">*</span></label>
                            @if($hasSeuil)
                                <select name="candidature_id" id="candidature_id" class="form-control" required>
                                    @foreach($eligibles as $c)
                                        <option value="{{ $c->id }}">
                                            {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <select id="candidature_id" class="form-control" disabled>
                                    <option>Aucun candidat éligible</option>
                                </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="duree"><i class="far fa-clock mr-1"></i>Durée (minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="duree" id="duree" class="form-control" value="60" min="15" max="240" required>
                        </div>

                        <div class="form-group">
                            <label for="lieu"><i class="fas fa-map-marker-alt mr-1"></i>Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="lieu" id="lieu" class="form-control" placeholder="Salle RH / Visioconférence" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        selectable: true,
        editable: false,
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour'
        },
        dateClick: function(info) {
            const dateEntretien = info.dateStr + 'T09:00';
            document.getElementById('date_entretien').value = dateEntretien;
            $('#entretienModal').modal('show');
        },
        events: [
            @foreach($entretiens as $e)
            {
                title: "{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}",
                start: "{{ $e->date_entretien }}",
                end: "{{ \Carbon\Carbon::parse($e->date_entretien)->addMinutes($e->duree) }}",
                backgroundColor: "{{ $e->statut === 'planifie' ? '#007bff' : ($e->statut === 'confirme' ? '#28a745' : '#6c757d') }}",
                borderColor: "{{ $e->statut === 'planifie' ? '#0056b3' : ($e->statut === 'confirme' ? '#1e7e34' : '#545b62') }}",
                description: "{{ $e->candidature->annonce->titre }} — {{ $e->lieu }}",
                statut: "{{ $e->statut }}"
            },
            @endforeach
        ],
        eventClick: function(info) {
            const statutBadge = info.event.extendedProps.statut === 'planifie' ? '<span class="badge badge-primary">Planifié</span>' : 
                                info.event.extendedProps.statut === 'confirme' ? '<span class="badge badge-success">Confirmé</span>' : 
                                '<span class="badge badge-secondary">' + info.event.extendedProps.statut + '</span>';
            
            Swal.fire({
                title: info.event.title,
                html: '<p><strong>Description:</strong> ' + info.event.extendedProps.description + '</p>' +
                      '<p><strong>Statut:</strong> ' + statutBadge + '</p>',
                icon: 'info',
                confirmButtonText: 'Fermer'
            });
        }
    });

    calendar.render();
});
</script>
@endpush
