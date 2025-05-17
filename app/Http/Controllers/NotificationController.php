<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show all notifications
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications; // includes read and unread

        return view('notifications.index', compact('notifications'));
    }

    // Mark single notification as read and redirect
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect($notification->data['url']); // redirect to user detail page
    }

    // Optionally: mark all as read
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('status', 'All notifications marked as read.');
    }
}
