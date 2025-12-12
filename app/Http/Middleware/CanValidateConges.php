<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DemandeCongé;
use App\Models\Employe;

class CanValidateConges
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = session('user_role');
        $userId = session('user_id');

        // RH peut valider toutes les demandes
        if ($userRole === 'rh') {
            return $next($request);
        }

        // Manager ne peut valider que les demandes de son équipe
        if ($userRole === 'manager') {
            $demandeCongé = $request->route('demandeCongé');
            
            if ($demandeCongé) {
                $manager = Employe::where('user_id', $userId)->first();
                
                if ($manager && $demandeCongé->employe->manager_id === $manager->id) {
                    return $next($request);
                }
            }
        }

        return redirect()->back()->with('error', 'Vous n\'avez pas la permission d\'effectuer cette action');
    }
}
