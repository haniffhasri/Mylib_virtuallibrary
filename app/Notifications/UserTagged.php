<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserTagged extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // optional: add 'mail' or 'broadcast'
    }

    public function toDatabase($notifiable){
        $commentable = $this->comment->commentable;

        $route = match (get_class($commentable)) {
            \App\Models\Thread::class => route('threads.show', $commentable->id),
            \App\Models\Book::class => route('book.show', $commentable->id),
            default => '#',
        };

        return [
            'message' => "{$this->comment->user->name} mentioned you in a comment.",
            'comment_id' => $this->comment->id,
            'url' => $route . '#comment-' . $this->comment->id,
        ];
    }

}
