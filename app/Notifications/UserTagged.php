<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Thread;
use App\Models\Book;

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
        return ['database']; 
    }

    public function toDatabase($notifiable){
        $commentable = $this->comment->commentable;

        $route = match (get_class($commentable)) {
            Thread::class => route('threads.show', $commentable->id),
            Book::class => route('book.show', $commentable->id),
            default => '#',
        };

        return [
            'message' => "{$this->comment->user->username} mentioned you in a comment.",
            'comment_id' => $this->comment->id,
            'url' => $route . '#comment-' . $this->comment->id,
        ];
    }
}
