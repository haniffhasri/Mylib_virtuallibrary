<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Log;
use App\Models\Book;

class NewBookNotification extends Notification
{
    use Queueable;

    public $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function via($notifiable)
    {
        Log::info('NewBookNotification fired for user: ' . $notifiable->id);
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Book Added!')
            ->greeting("Hello {$notifiable->name},")
            ->line('A new book has been added into our database.')
            ->action('Please check it out.', url('/book'))
            ->line('Happy reading!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "New Book registered: {$this->book->book_title} by ({$this->book->author})",
            'type' => 'book',
            'resource_id' => $this->book->id,
            'url' => '/book',
        ];
    }
}
