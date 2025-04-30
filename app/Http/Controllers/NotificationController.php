<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index', [
            'notifications' => Auth::user()->unreadNotifications,
        ]);
    }
}
