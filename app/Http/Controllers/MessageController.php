<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    public function __construct()
    {
        // Middlewares are now handled in routes
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request, CivilAct $civilAct)
    {
        Gate::authorize('view', $civilAct);
        
        $request->validate([
            'message' => 'required|string|max:1000',
            'message_type' => 'required|in:general,document_request,status_update,rejection,validation',
        ]);

        $user = Auth::user();
        
        // Determine recipient
        $recipientId = $user->isCitizen() 
            ? $this->getAgentForCivilAct($civilAct)->id 
            : $civilAct->user_id;

        $message = $civilAct->messages()->create([
            'sender_id' => $user->id,
            'recipient_id' => $recipientId,
            'message' => $request->message,
            'message_type' => $request->message_type,
        ]);

        // Send notification to recipient
        $this->sendMessageNotification($message);

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Message envoyé avec succès.');
    }

    /**
     * Mark a message as read.
     */
    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message->civilAct);
        
        if ($message->recipient_id === Auth::id()) {
            $message->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Get messages for a civil act (AJAX).
     */
    public function getMessages(CivilAct $civilAct)
    {
        Gate::authorize('view', $civilAct);
        
        $messages = $civilAct->messages()
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Get unread message count for current user.
     */
    public function getUnreadCount()
    {
        $count = Message::where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get agent assigned to a civil act.
     */
    private function getAgentForCivilAct(CivilAct $civilAct)
    {
        // For now, we'll just get the first available agent
        // In a real application, this would be more sophisticated
        $agent = \App\Models\User::where('role', 'agent')
            ->where('is_active', true)
            ->first();

        if (!$agent) {
            // If no agent is available, assign to admin
            $agent = \App\Models\User::where('role', 'admin')
                ->where('is_active', true)
                ->first();
        }

        return $agent;
    }

    /**
     * Send message notification.
     */
    private function sendMessageNotification(Message $message)
    {
        // In a real application, this would send push notifications, emails, or SMS
        \Log::info("New message sent", [
            'message_id' => $message->id,
            'civil_act_id' => $message->civil_act_id,
            'sender_id' => $message->sender_id,
            'recipient_id' => $message->recipient_id,
        ]);
    }
}