@extends('layouts.app')
@section('title','Calendrier des entretiens')
@section('page-title','Planification via calendrier')

@section('content')
@include('layouts.alerts')

{{-- Import Bootstrap + FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<div id="calendar" class="bg-white p-3 rounded shadow-sm"></div>


<!-- Modal pour planifier -->
<div class="modal fade" id="entretienModal" tabindex="-1" aria-labelledby="entretienModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form id="formEntretien" method="POST" action="{{ route('entretiens.create') }}">
        @csrf
        <h5 class="mb-3">Planifier un entretien</h5>

        <input type="hidden" name="date_entretien" id="date_entretien">

        <div class="mb-3">
          <label for="candidature_id">Candidat :</label>
          <select name="candidature_id" class="form-select" required>
              <option value="">-- Sélectionner un candidat éligible (≥ {{ $seuil }}) --</option>
              @foreach($candidaturesEligibles as $c)
                  <option value="{{ $c->id }}">
                      {{ $c->candidat->nom }} {{ $c->candidat->prenom }} — {{ $c->annonce->titre }}
                  </option>
              @endforeach
          </select>
        </div>


        <div class="mb-3">
          <label for="duree">Durée (minutes) :</label>
          <input type="number" name="duree" class="form-control" value="60" min="15" required>
        </div>

        <div class="mb-3">
          <label for="lieu">Lieu :</label>
          <input type="text" name="lieu" class="form-control" placeholder="Salle RH / visioconférence" required>
        </div>

        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        selectable: true,
        editable: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
            const dateEntretien = info.dateStr + 'T09:00';
            document.getElementById('date_entretien').value = dateEntretien;

            // ✅ Ouvre le modal Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('entretienModal'));
            modal.show();
        },
        events: [
            @foreach($entretiens as $e)
            {
                title: "{{ $e->candidature->candidat->nom }} {{ $e->candidature->candidat->prenom }}",
                start: "{{ $e->date_entretien }}",
                end: "{{ \Carbon\Carbon::parse($e->date_entretien)->addMinutes($e->duree) }}",
                backgroundColor: "{{ $e->statut === 'planifie' ? '#0d6efd' : '#6c757d' }}",
                description: "{{ $e->candidature->annonce->titre }} — {{ $e->lieu }}"
            },
            @endforeach
        ],
        eventClick: function(info) {
            alert(info.event.title + "\n" + info.event.extendedProps.description);
        }
    });

    calendar.render();
});
</script>
@endsection
