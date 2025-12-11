<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\SoldeCongé;
use App\Models\TypeCongé;
use App\Services\CalculSoldeService;
use Illuminate\Http\Request;

class SoldeCongéController extends Controller
{
    protected $calculSoldeService;

    public function __construct(CalculSoldeService $calculSoldeService)
    {
        $this->calculSoldeService = $calculSoldeService;
    }

    public function index()
    {
        $soldes = SoldeCongé::with(['employe', 'typeCongé'])
            ->orderBy('date_debut_periode', 'desc')
            ->paginate(15);

        return view('conges.soldes.index', compact('soldes'));
    }

    public function show(Employe $employe)
    {
        $soldes = SoldeCongé::where('employe_id', $employe->id)
            ->with('typeCongé')
            ->get();

        return view('conges.soldes.show', compact('employe', 'soldes'));
    }

    public function recalculer(Employe $employe)
    {
        $typesConges = TypeCongé::where('est_actif', true)->get();

        foreach ($typesConges as $type) {
            $this->calculSoldeService->calculerSoldeAnnuel($employe, $type);
        }

        return redirect()->route('soldes-conges.show', $employe->id)
            ->with('success', 'Soldes de congés recalculés');
    }
}
