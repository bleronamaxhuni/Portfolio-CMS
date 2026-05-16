<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $contactMessage,
    ) {
    }

    public function build(): self
    {
        return $this->subject('Portfolio Contact Message')
            ->replyTo($this->senderEmail, $this->senderName)
            ->view('emails.contact-message')
            ->with([
                'name' => $this->senderName,
                'email' => $this->senderEmail,
                'user_message' => $this->contactMessage,
            ]);
    }
}
