<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\NewUserNotification;
use App\Notifications\NewWelcomeNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

class HandleUserRegistered
{
    /**
     * Create the event listener.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(new newWelcomeNotification());
        $user = $event->user;
        $admins = User::where('usertype', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewUserNotification($user));
        }
    }
}
