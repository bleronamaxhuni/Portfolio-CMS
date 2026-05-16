<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Admin\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $stored = Message::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => 'Portfolio contact',
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $this->sendNotificationEmail($stored, $validated['name'], $validated['email'], $validated['message']);

        return $this->respond(
            $request,
            true,
            'Thanks! Your message has been sent.'
        );
    }

    private function sendNotificationEmail(Message $stored, string $name, string $email, string $body): void
    {
        $recipient = config('portfolio.contact_to');

        if (empty($recipient)) {
            $recipient = User::query()->where('is_admin', true)->value('email');
        }

        if (empty($recipient)) {
            $recipient = config('mail.from.address');
        }

        if (empty($recipient)) {
            Log::warning('Contact form saved but no recipient email is configured.');

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactMessageMail($name, $email, $body));
        } catch (\Throwable $e) {
            report($e);
            Log::error('Contact form email failed', [
                'message_id' => $stored->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function respond(Request $request, bool $success, string $message, array $errors = [])
    {
        if ($request->expectsJson()) {
            if (! $success) {
                return response()->json([
                    'message' => $message,
                    'errors' => $errors,
                ], 422);
            }

            return response()->json(['message' => $message]);
        }

        if (! $success) {
            return back()->withErrors($errors ?: ['contact' => $message]);
        }

        return back()->with('success', $message);
    }
}
