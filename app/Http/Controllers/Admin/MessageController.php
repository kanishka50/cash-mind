<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     */
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Check if the admin is the sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Mark as read if admin is the receiver
        if ($message->receiver_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Display form to create a new message.
     */
    public function create()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.messages.create', compact('users'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'subject' => $validated['subject'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message sent successfully.');
    }

    /**
     * Delete the specified message.
     */
    public function destroy(Message $message)
    {
        // Check if the admin is the sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}