<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Models\Tickets\TicketActivity;
use App\Repositories\TicketActivityRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\TicketActivityRepository
 */
final class TicketActivityRepositoryTest extends TestCase
{
    public function testFindSupportTickets(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $user = $this->env->user()->user;

        $ticketActivity = $this->env->ticketActivity([
            'ticket_id' => $ticket->getId(),
            'user_id' => $user->getId(),
        ])->ticketActivity ;

        $repository = new TicketActivityRepository();

        $findAllTicketActivities = $repository->findAllTicketActivities($ticket);

        /** @var \App\Models\Tickets\TicketActivity $actual */
        $actual = $findAllTicketActivities->find($ticketActivity->getId());

        $this->assertEquals($ticket->getId(), $ticketActivity->getTicketId());

        $this->assertNotNull($actual);

        $this->assertArrayHasKeys(
            [
                'ticket_id',
                'activity',
                'user_id',
                'created_at'
            ],
            $actual->toArray()
        );
    }

}
