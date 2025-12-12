<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entretien;
use App\Models\DemandeCongé;
use App\Models\Employe;

class CalendrierGlobalController extends Controller
{
    public function index(Request $request)
    {
        $typeAffichage = $request->input('type', 'tous'); // tous, entretiens, conges
        $employe_id = $request->input('employe_id');

        // Récupérer les entretiens
        $entretiens = Entretien::with('candidature.candidat', 'candidature.annonce')
            ->orderBy('date_entretien', 'asc')
            ->get();

        // Récupérer les congés approuvés
        $conges = DemandeCongé::with(['employe.candidat', 'typeCongé'])
            ->where('statut_id', 2) // Approuvés uniquement
            ->when($employe_id, fn($q) => $q->where('employe_id', $employe_id))
            ->orderBy('date_debut', 'asc')
            ->get();

        // Récupérer la liste des employés pour le filtre
        $employes = Employe::with('candidat')->get();

        // Filtrer selon le type d'affichage
        if ($typeAffichage === 'entretiens') {
            $conges = collect();
        } elseif ($typeAffichage === 'conges') {
            $entretiens = collect();
        }

        // Préparer les événements pour FullCalendar
        $events = $this->prepareEvents($entretiens, $conges);

        return view('rh.calendrier.global', compact(
            'events',
            'entretiens',
            'conges',
            'employes',
            'typeAffichage',
            'employe_id'
        ));
    }

    private function prepareEvents($entretiens, $conges)
    {
        $events = [];

        // Ajouter les entretiens
        foreach ($entretiens as $entretien) {
            $events[] = [
                'id' => 'entretien-' . $entretien->id,
                'title' => '🎤 ' . $entretien->candidature->candidat->nom . ' ' . $entretien->candidature->candidat->prenom,
                'start' => $entretien->date_entretien,
                'backgroundColor' => '#007bff',
                'borderColor' => '#0056b3',
                'extendedProps' => [
                    'type' => 'entretien',
                    'lieu' => $entretien->lieu,
                    'poste' => $entretien->candidature->annonce->titre,
                ],
            ];
        }

        // Ajouter les congés
        foreach ($conges as $conge) {
            $events[] = [
                'id' => 'conge-' . $conge->id,
                'title' => '🏖️ ' . $conge->employe->candidat->nom . ' (' . $conge->typeCongé->nom . ')',
                'start' => $conge->date_debut,
                'end' => $conge->date_fin,
                'backgroundColor' => '#28a745',
                'borderColor' => '#1e7e34',
                'extendedProps' => [
                    'type' => 'conge',
                    'jours' => $conge->nombre_jours,
                    'type_conge' => $conge->typeCongé->nom,
                ],
            ];
        }

        return $events;
    }
}
