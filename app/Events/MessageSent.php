<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected ChatMessage $chatMessage;

    public function __construct(ChatMessage $chatMessage) {
        $this->chatMessage = $chatMessage->load('sender');
    }

    public function broadcastWith(): array
    {
        return [
            'chatMessage' => $this->chatMessage
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->chatMessage->receiver_id),
        ];
    }
}
