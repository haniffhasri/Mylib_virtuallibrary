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
    public function markAsRead($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $data = $notification->data;

        // Check for comment-related notification
        if (isset($data['comment_id'])) {
            $comment = \App\Models\Comment::find($data['comment_id']);
            if (!$comment) {
                return redirect()->route('notifications.index')->with('error', 'Comment has been deleted.');
            }

            return redirect($data['url']);
        }

        // Check for new user (account) notification
        if (isset($data['id'])) {
            $user = \App\Models\User::find($data['id']);
            if (!$user) {
                return redirect()->route('notifications.index')->with('error', 'User account has been deleted.');
            }

            return redirect($data['url']);
        }

        return redirect()->route('notifications.index')->with('error', 'Invalid notification data.');
    }



    // Optionally: mark all as read
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('status', 'All notifications marked as read.');
    }

    public function fetch()
    {
        $notifications = Auth::user()->unreadNotifications()->take(5)->get();

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count(),
        ]);
    }
}
