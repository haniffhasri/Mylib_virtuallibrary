<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NewUserNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        Log::info('NewUserNotification fired for user: ' . $notifiable->id);
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New user registered: {$this->user->username} ({$this->user->email})",
            'type' => 'user',
            'resource_id' => $this->user->id,
            'url' => '/admin/user',
        ];
    }
}
