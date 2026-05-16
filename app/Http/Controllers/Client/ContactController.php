<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Jobs\SendContactNotification;
use App\Models\Admin\Message;
use Illuminate\Http\Request;

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

        SendContactNotification::dispatch($stored->id);

        return $this->respond(
            $request,
            true,
            'Thanks! Your message has been sent.'
        );
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
