<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\HistoriqueCongé;
use Illuminate\Http\Request;

class HistoriqueCongéController extends Controller
{
    public function index()
    {
        $historiques = HistoriqueCongé::with(['employe', 'typeCongé', 'validateur'])
            ->orderBy('date_enregistrement', 'desc')
            ->paginate(15);

        return view('conges.historiques.index', compact('historiques'));
    }

    public function show(Employe $employe)
    {
        $historiques = HistoriqueCongé::where('employe_id', $employe->id)
            ->with(['typeCongé', 'validateur'])
            ->orderBy('date_enregistrement', 'desc')
            ->paginate(15);

        return view('conges.historiques.show', compact('employe', 'historiques'));
    }
}
