<?php

namespace App\Events\SupportChat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

abstract class SupportChat implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $ticketId,$message;

    public function __construct($ticketId,$message)
    {
        $this->ticketId = $ticketId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('ticket.'.$this->ticketId);
    }
    
    abstract public function broadcastAs();
}



