<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Http\Requests\ChatMessage\CreateChatMessageRequest;
use Illuminate\Support\Facades\Auth;

final class ChatController extends Controller
{
    public function chatPage(User $user)
    {
        $chatMessages = ChatMessage::query()
            ->where(function ($query) use ($user) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('id')
            ->get();

        return Inertia::render('Chat', [
            'user' => $user,
            'chatMessages' => $chatMessages
        ]);
    }

    public function sendMessage(User $receiver, CreateChatMessageRequest $request)
    {
        $chatMessage = ChatMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'message' => $request->validated()['newMessage']
        ]);

        broadcast(new MessageSent($chatMessage))->toOthers();

        return back();
    }
}
