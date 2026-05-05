<?php

namespace App\Events\SupportChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class Message extends SupportChat
{
    public function broadcastAs()
    {
        return 'Message';
    }
}