<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    public function getUnread()
    {
        $notifications = Auth::user()->unreadNotifications()->limit(5)->get();
        
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count(),
            'notifications' => $notifications
        ]);
    }
}
