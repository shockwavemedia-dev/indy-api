<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\TicketEmailRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\TicketEmailRepository
 */
final class TicketEmailRepositoryTest extends TestCase
{
    public function testFindByTicket(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $this->env->ticketEmail(
            [
                'ticket_id' => $ticket->getId()
            ]
        )->ticketEmail;

        $repository = new TicketEmailRepository();

        $findByTicket = $repository->findByTicket($ticket);

        $ticket->refresh();

        $this->assertEquals(1, $findByTicket->count());
    }

    public function testMarkAsReadSuccess(): void
    {
        $user = $this->env->user()->user;

        $ticketEmail = $this->env->ticketEmail(
            [
                'sender_by' => $user->getId(),
                'updated_by' => $user->getId(),
                'sender_type' => $user->getUserType()->getType()->getValue()
            ]
        )->ticketEmail;

        $repository = new TicketEmailRepository();

        $ticketEmail = $repository->markAsRead($ticketEmail, $user, true);

        self::assertEquals(true, $ticketEmail->isRead());
    }
}
