<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(
                Message::query()
                    ->orderByDesc('created_at')
                    ->paginate(10)
            );
        }

        return view('admin.messages');
    }

    public function show(string $id)
    {
        $message = Message::findOrFail($id);

        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return response()->json($message);
    }

    public function update(Request $request, string $id)
    {
        $message = Message::findOrFail($id);

        $data = $request->validate([
            'is_read' => 'sometimes|boolean',
        ]);

        $message->update($data);

        return response()->json($message);
    }

    public function destroy(string $id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(null, 204);
    }
}
