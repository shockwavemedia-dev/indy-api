<?php

namespace App\Events\Tickets;

use App\Http\Resources\API\Tickets\TicketEmailResource;
use App\Http\Resources\API\Tickets\TicketEmailsResource;
use App\Models\Tickets\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Queue\SerializesModels;

class TicketEmailsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Collection $ticketEmails;

    private Ticket $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $ticketEmails, Ticket $ticket)
    {
        $this->ticketEmails = $ticketEmails;
        $this->ticket = $ticket->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel(
            \sprintf('ticket-emails.%s', $this->ticket->getId()),
        );
    }

    public function broadcastAs()
    {
        return 'ticket-emails-event';
    }

    public function broadcastWith(): array
    {
        $ticketEmails = [];

        foreach ($this->ticketEmails as $email) {
            $ticketEmails['data'][] = new TicketEmailResource($email);
        }

        return $ticketEmails;
    }
}
