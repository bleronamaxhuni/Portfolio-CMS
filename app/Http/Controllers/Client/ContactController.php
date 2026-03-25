<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $recipient = env('CONTACT_TO_ADDRESS');
        if (empty($recipient)) {
            // Fallback to the first admin user's email (so the form works without extra env setup).
            $recipient = User::query()->where('is_admin', true)->value('email') ?: env('MAIL_FROM_ADDRESS');
        }
        if (empty($recipient)) {
            return back()->withErrors([
                'contact' => 'Contact recipient is not configured. Please set CONTACT_TO_ADDRESS in your .env file.',
            ]);
        }

        try {
            Mail::to($recipient)->send(new ContactMessageMail(
                $validated['name'],
                $validated['email'],
                $validated['message'],
            ));
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'contact' => 'Unable to send your message right now. Please try again later.',
            ]);
        }

        return back()->with('success', 'Thanks! Your message has been sent.');
    }
}

