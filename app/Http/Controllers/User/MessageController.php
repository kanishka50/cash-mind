<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the user's messages.
     */
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(10);

        return view('user.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        // Get admin users for the recipient dropdown
        $admins = User::where('is_admin', true)->get();
        
        return view('user.messages.create', compact('admins'));
    }

    /**
     * Store a newly created message in storage.
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

        return redirect()->route('user.messages.index')
            ->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Check if the user is the sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Mark as read if user is the receiver
        if ($message->receiver_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('user.messages.show', compact('message'));
    }

    /**
     * Reply to a message.
     */
    public function reply(Request $request, Message $message)
    {
        // Check if the user is the sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        // Create reply message
        $reply = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $message->sender_id === Auth::id() ? $message->receiver_id : $message->sender_id,
            'subject' => 'Re: ' . $message->subject,
            'content' => $validated['content'],
        ]);

        return redirect()->route('user.messages.show', $reply)
            ->with('success', 'Reply sent successfully.');
    }

    /**
     * Delete the specified message.
     */
    public function destroy(Message $message)
    {
        // Check if the user is the sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        return redirect()->route('user.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}