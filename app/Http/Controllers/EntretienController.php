<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Entretien;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\ResultatTest;


class EntretienController extends Controller
{

    // 2️⃣ Planifier un entretien
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'candidature_id' => 'required|integer',
                'date_entretien' => 'required|date',
                'duree' => 'required|integer|min:15',
                'lieu' => 'required|string|max:150',
            ]);

            $entretien = Entretien::create([
                'candidature_id' => $request->candidature_id,
                'date_entretien' => $request->date_entretien,
                'duree' => $request->duree,
                'lieu' => $request->lieu,
                'rh_id' => session('user_id'),
                'statut' => 'planifie'
            ]);

            $cand = $entretien->candidature->candidat;

            // 🔔 Notification automatique
            NotificationService::send(
                'entretien',
                'candidat',
                $cand->id,
                [
                    'message' => "Un entretien est prévu le {$entretien->date_entretien} pour le poste '{$entretien->candidature->annonce->titre}'.",
                    'lieu' => $entretien->lieu
                ]
            );
      

            return redirect()->route('entretiens.index')->with('success', 'Entretien planifié avec succès.');
        }

        $candidatures = Candidature::with('candidat', 'annonce')
            ->where('score_global', '>', 0)
            ->get();

        return view('rh.entretiens.create', compact('candidatures'));
    }

    // 3️⃣ Modifier / supprimer un entretien
    public function delete($id)
    {
        $entretien = Entretien::findOrFail($id);
        $entretien->delete();
        return redirect()->back()->with('success', 'Entretien supprimé.');
    }

    // 4️⃣ Afficher le calendrier global
    public function index(Request $request)
    {
        $annonceId = $request->input('annonce_id'); // si filtre, sinon null

        $seuil = ResultatTest::when($annonceId, function($q) use ($annonceId) {
                    $q->whereHas('candidature', fn($cq) => $cq->where('annonce_id', $annonceId));
                })
                ->max('score'); // peut être null si aucun résultat

        $hasSeuil = $seuil !== null;

        $eligibles = $hasSeuil
            ? Candidature::with('candidat','annonce')
                ->when($annonceId, fn($q)=>$q->where('annonce_id',$annonceId))
                ->whereIn('id', ResultatTest::select('candidature_id')
                    ->when($annonceId, function($q) use ($annonceId){
                        $q->whereHas('candidature', fn($cq)=>$cq->where('annonce_id',$annonceId));
                    })
                    ->where('score','>=',$seuil))
                ->get()
            : collect();

        $entretiens = Entretien::with('candidature.candidat','candidature.annonce')
            ->when($annonceId, fn($q)=>$q->whereHas('candidature', fn($cq)=>$cq->where('annonce_id',$annonceId)))
            ->orderByDesc('date_entretien')
            ->get();

        return view('rh.entretiens.index', compact('entretiens','eligibles','seuil','hasSeuil','annonceId'));
    }

    public function calendrier(Request $request)
    {
        $annonceId = $request->input('annonce_id');

        $seuil = ResultatTest::when($annonceId, function($q) use ($annonceId) {
                    $q->whereHas('candidature', fn($cq) => $cq->where('annonce_id', $annonceId));
                })
                ->max('score'); // null si aucun

        $hasSeuil = $seuil !== null;

        $eligibles = $hasSeuil
            ? Candidature::with('candidat','annonce')
                ->when($annonceId, fn($q)=>$q->where('annonce_id',$annonceId))
                ->whereIn('id', ResultatTest::select('candidature_id')
                    ->when($annonceId, function($q) use ($annonceId){
                        $q->whereHas('candidature', fn($cq)=>$cq->where('annonce_id',$annonceId));
                    })
                    ->where('score','>=',$seuil))
                ->get()
            : collect();

        // Toujours définir $entretiens
        $entretiens = Entretien::with('candidature.candidat','candidature.annonce')
            ->when($annonceId, fn($q)=>$q->whereHas('candidature', fn($cq)=>$cq->where('annonce_id',$annonceId)))
            ->orderBy('date_entretien','asc')
            ->get();

        // Optionnel: events pour FullCalendar
        $events = $entretiens->map(function($e){
            return [
                'id'    => $e->id,
                'title' => $e->candidature->candidat->nom.' '.$e->candidature->candidat->prenom.' — '.$e->candidature->annonce->titre,
                'start' => $e->date_entretien, // ISO 8601
                'extendedProps' => [
                    'lieu' => $e->lieu,
                    'statut' => $e->statut,
                ],
            ];
        })->values()->toArray();

        return view('rh.entretiens.calendrier', compact(
            'events','entretiens','eligibles','seuil','hasSeuil','annonceId'
        ));

    }


}
