<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Welcome to AI Wallpapers'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view_name = 'mails.welcome';

        if (!view()->exists($view_name . '_' . $this->locale)) {
            $view_name = 'mails.welcome_en';
        } else {
            $view_name = 'mails.welcome_' . $this->locale;
        }

        return new Content(
            view: $view_name
        );
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
