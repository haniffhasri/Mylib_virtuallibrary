<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    public function __construct(private $comment) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New comment posted in thread: {$this->comment->thread->title}",
            'comment_id' => $this->comment->id,
            'thread_id' => $this->comment->thread_id,
        ];
    }
}
