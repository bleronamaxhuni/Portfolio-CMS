<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $message,
    ) {
    }

    public function build(): self
    {
        return $this->subject('Portfolio Contact Message')
            ->replyTo($this->email, $this->name)
            ->view('emails.contact-message')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message,
            ]);
    }
}

