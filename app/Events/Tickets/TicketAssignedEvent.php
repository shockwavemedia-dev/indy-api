<?php

namespace App\Events\Tickets;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketAssignedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    private Ticket $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
        $this->ticket = $ticket->withoutRelations();
        $this->user = $user->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel(
            \sprintf('user-tickets.%s', $this->user->getId()),
        );
    }

    public function broadcastAs()
    {
        return 'ticket-assigned-event';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->user->getId(),
            'first_name' => $this->user->getFirstName(),
            'last_name' => $this->user->getLastName(),
            'ticket_id' => $this->ticket->getId(),
            'ticket_code' => $this->ticket->getTicketCode(),
            'duedate' => $this->ticket->getDueDate(),
            'client_id' => $this->ticket->getClientId(),
        ];
    }
}
