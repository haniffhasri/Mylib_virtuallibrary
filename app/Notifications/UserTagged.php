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

        if ($commentable instanceof \App\Models\Thread) {
            $url = route('threads.show', ['thread' => $commentable->id]) . '#comment-' . $this->comment->id;
        } elseif ($commentable instanceof \App\Models\Book) {
            $url = route('book.show', ['id' => $commentable->id]) . '#comment-' . $this->comment->id;
        } else {
            $url = url('/'); // fallback
        }

        return [
            'message' => "{$this->comment->user->name} mentioned you in a comment.",
            'comment_id' => $this->comment->id,
            'url' => $url, 
        ];
    }

}
