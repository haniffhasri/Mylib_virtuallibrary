<?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class SendWelcomeMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     /**
//      * Create a new message instance.
//      */

//      public $WelcomeMessage;


//     public function __construct($WelcomeMessage)
//     {
//         $this->WelcomeMessage = $WelcomeMessage;
//     }

//     /**
//      * Get the message envelope.
//      */
//     public function envelope(): Envelope
//     {
//         return new Envelope(
//             subject: 'Send Welcome Mail using Mailtrap',
//         );
//     }

//     /**
//      * Get the message content definition.
//      */
//     public function content(): Content
//     {
//         return new Content(
//             view: 'WelcomeMail',
//             with: [
//                 'WelcomeMessage' => $this->WelcomeMessage,
//             ]
//         );
//     }

//     /**
//      * Get the attachments for the message.
//      *
//      * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//      */
//     public function attachments(): array
//     {
//         return [];
//     }
// }
