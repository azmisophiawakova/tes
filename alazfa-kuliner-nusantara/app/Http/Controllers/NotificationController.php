<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('id_user', Auth::id())->orderBy('created_at', 'desc')->get();
        if ($request->wantsJson()) return response()->json($notifications);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id_user', Auth::id())->findOrFail($id);
        $notification->update(['status_baca' => true]);

        if ($request->wantsJson()) return response()->json(['message' => 'Telah dibaca']);
        return redirect()->back();
    }
}
