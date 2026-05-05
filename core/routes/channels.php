<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\SupportTicket;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Example of a private channel for a specific user
Broadcast::channel('ticket.{id}', function ($ticketId,$message) {
    $ticket=SupportTicket::find($message->support_ticket_id);
    return $ticketId == $ticket->user_id || auth('admin')->user();
});
