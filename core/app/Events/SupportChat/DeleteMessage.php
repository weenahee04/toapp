<?php

namespace App\Events\SupportChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class DeleteMessage extends SupportChat
{
    public function broadcastAs()
    {
        return 'DeleteMessage';
    }
}