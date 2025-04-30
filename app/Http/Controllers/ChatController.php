<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMessage;
use Inertia\Inertia;

final class ChatController extends Controller
{
    public function chatPage(User $user)
    {
        $chatMessages = ChatMessage::query()
            ->where(function ($query) use ($user) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('id')
            ->get();

        return Inertia::render('Chat', [
            'user' => $user,
            'chatMessages' => $chatMessages
        ]);
    }
}
