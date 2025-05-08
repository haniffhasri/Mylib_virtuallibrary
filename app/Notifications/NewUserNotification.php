<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Send it via database, not mail
    public function via($notifiable)
    {
        return ['database'];
    }

    // Store the notification content in the DB
    public function toArray($notifiable)
    {
        return [
            'message' => "New user registered: {$this->user->name} ({$this->user->email})",
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'url' => url('/admin/user/' . $this->user->id),
        ];
    }
}
