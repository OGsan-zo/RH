<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationCongesController extends Controller
{
    /**
     * Afficher toutes les notifications de l'utilisateur
     */
    public function index()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }

        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.conges.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function marquerCommeLue($notificationId)
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }

        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marquée comme lue');
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function marquerToutCommeLu()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }

        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }

    /**
     * Supprimer une notification
     */
    public function supprimer($notificationId)
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé');
        }

        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Notification supprimée');
    }

    /**
     * Obtenir le nombre de notifications non lues (pour AJAX)
     */
    public function compterNonLues()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = $user->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }
}
