<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Candidat;

class NotificationController extends Controller
{
    // 1️⃣ Liste des notifications
    public function index(Request $request)
    {
        $userRole = strtolower(session('user_role')); // rh ou candidat
        $userId   = session('user_id');
        $filter   = $request->input('type');

        if (!$userRole || !$userId) {
            return redirect()->route('login.form')->with('error', 'Session expirée.');
        }

        // 🧠 Si c’est un candidat, on va chercher son id de table "candidats"
        $candidatId = null;
        if ($userRole === 'candidat') {
            $candidatId = Candidat::where('user_id', $userId)->value('id');
        }

        $notifications = Notification::query()
            ->where(function ($q) use ($userRole, $userId, $candidatId) {
                if ($userRole === 'rh') {
                    $q->where('notifiable_type', 'rh')
                    ->where(function ($sub) use ($userId) {
                        $sub->where('notifiable_id', 0)
                            ->orWhere('notifiable_id', $userId);
                    });
                } else {
                    // ✅ pour le candidat, on compare à son id dans la table "candidats"
                    $q->where('notifiable_type', 'candidat')
                    ->where('notifiable_id', $candidatId);
                }
            })
            ->when($filter, fn($q) => $q->where('type', $filter))
            ->orderByDesc('created_at')
            ->get();

        return view('notifications.index', compact('notifications','filter','userRole'));
    }



    // 2️⃣ Marquer comme lu
    public function read($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->markAsRead();
        return back()->with('success', 'Notification marquée comme lue.');
    }
}
