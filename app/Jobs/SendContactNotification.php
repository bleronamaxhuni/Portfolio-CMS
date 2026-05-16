<?php

namespace App\Jobs;

use App\Mail\ContactMessageMail;
use App\Models\Admin\Message;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactNotification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(public int $messageId)
    {
    }

    public function handle(): void
    {
        $message = Message::query()->find($this->messageId);

        if (! $message) {
            Log::warning('Contact notification skipped: message not found.', [
                'message_id' => $this->messageId,
            ]);

            return;
        }

        $recipient = config('portfolio.contact_to');

        if (empty($recipient)) {
            $recipient = User::query()->where('is_admin', true)->value('email');
        }

        if (empty($recipient)) {
            $recipient = config('mail.from.address');
        }

        if (empty($recipient)) {
            Log::warning('Contact notification skipped: no recipient configured.', [
                'message_id' => $message->id,
            ]);

            return;
        }

        Mail::to($recipient)->send(new ContactMessageMail(
            $message->name,
            $message->email,
            $message->message,
        ));
    }

    public function failed(?\Throwable $exception): void
    {
        Log::error('Contact notification job failed', [
            'message_id' => $this->messageId,
            'error' => $exception?->getMessage(),
        ]);
    }
}
