<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $acceptUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($insertedName, $url)
    {
        $this->name = $insertedName;
        $this->acceptUrl = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invite To Cleopatra',
        );
    }

    /**
     * Get the message content definition.
     */
//    public function content(): Content
//    {
//        return new Content(
//            view: 'mails.team-invitation',
//            with: (['name' => $this->name, 'acceptUrl' => $this->acceptUrl]),
//        );
//    }
    public function build()
    {
        return $this->markdown('mails.team-invitation')->with(['name' => $this->name, 'acceptUrl' => $this->acceptUrl]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
