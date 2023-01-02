<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Tickets\TicketEvent;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\TicketEvent
 */
final class TicketEventTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'ticket_id' => 1,
            'duedate' => new Carbon('03/01/2022'),
        ];

        $ticketEvent = new TicketEvent();
        $ticketEvent->setAttribute('id', 1);
        $ticketEvent->setAttribute('ticket_id', 1);
        $ticketEvent->setDueDate(new Carbon('03/01/2022'));

        $actual = [
            'id' => $ticketEvent->getId(),
            'ticket_id' => $ticketEvent->getTicketId(),
            'duedate' => $ticketEvent->getDueDate(),
        ];

        self::assertEquals($expected, $actual);
    }
}
