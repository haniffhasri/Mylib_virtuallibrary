<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Book;
class NewBookNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $book; 

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    // Send it via database, not mail
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Book Added!')
            ->greeting("Hello {$notifiable->name},")
            ->line('A new book has been added into our database.')
            ->action('Please check it out.', url('/book'))
            ->line('Happy reading!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable){
        return [
            'message' => "New Book registered: {$this->book->book_title} by ({$this->book->author})",
            'type' => 'book',
            'resource_id' => $this->book->id,
            'url' => route('book.index', $this->book->id),
        ];
    }
}
