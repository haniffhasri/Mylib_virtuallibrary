<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Thread;
use App\Models\Book;

class UserTagged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; 
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

    public function toBroadcast($notifiable){
        $commentable = $this->comment->commentable;

        $route = match (get_class($commentable)) {
            Thread::class => route('threads.show', $commentable->id),
            Book::class => route('book.show', $commentable->id),
            default => '#',
        };

        return new BroadcastMessage([
            'id' => $this->id, 
            'message' => "{$this->comment->user->username} mentioned you in a comment.",
            'url' => $route . '#comment-' . $this->comment->id,
        ]);
    }
}
