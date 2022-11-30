<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Tickets\TicketService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\TicketService
 */
final class TicketEventsServicesTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'ticket_event_id' => 1,
            'service_id' => 1,
            'created_by' => 1,
        ];

        $ticketEventServices = new TicketService();
        $ticketEventServices->setAttribute('id', 1);
        $ticketEventServices->setAttribute('ticket_event_id', 1);
        $ticketEventServices->setAttribute('service_id', 1);
        $ticketEventServices->setAttribute('created_by', 1);

        $actual = [
            'id' => $ticketEventServices->getId(),
            'ticket_event_id' => $ticketEventServices->getTicketEventId(),
            'service_id' => $ticketEventServices->getServiceId(),
            'created_by' => $ticketEventServices->getCreatedById(),
        ];

        self::assertEquals($expected, $actual);
    }
}
