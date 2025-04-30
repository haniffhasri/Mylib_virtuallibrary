<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserTagged extends Notification
{
    public function __construct(private $comment, private $tagger) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->tagger->name} tagged you in a comment.",
            'comment_id' => $this->comment->id,
            'thread_id' => $this->comment->thread_id,
        ];
    }
}
