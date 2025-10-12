<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // 1️⃣ Liste des notifications
    public function index(Request $request)
    {
        $userRole = session('role'); // 'rh' ou 'candidat'
        $userId = session('user_id');

        $filtre = $request->input('type');
        $notifications = Notification::where('notifiable_type', $userRole)
            ->where('notifiable_id', $userId)
            ->when($filtre, fn($q) => $q->where('type', $filtre))
            ->orderByDesc('created_at')
            ->get();

        return view('notifications.index', compact('notifications', 'filtre'));
    }

    // 2️⃣ Marquer comme lu
    public function read($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->markAsRead();
        return back()->with('success', 'Notification marquée comme lue.');
    }
}
