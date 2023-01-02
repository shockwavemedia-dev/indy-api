<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\Tickets\Ticket;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\Ticket
 */
final class TicketTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'client_id' => 1,
            'created_by' => 1,
            'created_by_user_type' => UserTypeEnum::ADMIN,
            'department_id' => 1,
            'requested_by' => 2,
            'ticket_code' => 'AAP-1',
            'subject' => 'Test Ticket',
            'description' => 'Test ticket demo',
            'type' => TicketTypeEnum::EMAIL,
            'status' => TicketStatusEnum::NEW,
        ];

        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);
        $ticket->setAttribute('client_id', 1);
        $ticket->setAttribute('created_by', 1);
        $ticket->setAttribute('created_by_user_type', UserTypeEnum::ADMIN);
        $ticket->setAttribute('department_id', 1);
        $ticket->setAttribute('requested_by', 2);
        $ticket->setAttribute('ticket_code', 'AAP-1');
        $ticket->setSubject('Test Ticket');
        $ticket->setDescription('Test ticket demo');
        $ticket->setType(new TicketTypeEnum(TicketTypeEnum::EMAIL));
        $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::NEW));

        $actual = [
            'id' => $ticket->getId(),
            'client_id' => $ticket->getClientId(),
            'created_by' => $ticket->getCreatedById(),
            'created_by_user_type' => $ticket->getCreatedByUserType(),
            'department_id' => $ticket->getDepartmentId(),
            'requested_by' => $ticket->getRequestedById(),
            'ticket_code' => $ticket->getTicketCode(),
            'subject' => $ticket->getSubject(),
            'description' => $ticket->getDescription(),
            'type' => $ticket->getType(),
            'status' => $ticket->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
}
