<?php

declare(strict_types=1);

 namespace Tests\Unit\Models;

 use App\Enum\TicketAssigneeStatusEnum;
 use App\Models\Tickets\TicketAssignee;
 use PHPUnit\Framework\TestCase;

 /**
  * @covers \App\Models\Tickets\TicketAssignee
  */
 final class TicketAssigneeTest extends TestCase
 {
     public function testGetterAndSetters(): void
    {

        $expected = [
            'id' => 1,
            'ticket_id' => 1,
            'admin_user_id' => 1,
            'department_id' => 1,
            'status' => TicketAssigneeStatusEnum::OPEN,
        ];

        $ticketAssignee = new TicketAssignee();
        $ticketAssignee->setAttribute('id', 1);
        $ticketAssignee->setAttribute('ticket_id', 1);
        $ticketAssignee->setAttribute('admin_user_id', 1);
        $ticketAssignee->setAttribute('department_id', 1);
        $ticketAssignee->setStatus(new TicketAssigneeStatusEnum(TicketAssigneeStatusEnum::OPEN));

        $actual = [
            'id' => $ticketAssignee->getId(),
            'ticket_id' => $ticketAssignee->getTicketId(),
            'admin_user_id' => $ticketAssignee->getAdminUserId(),
            'department_id' => $ticketAssignee->getDepartmentId(),
            'status' => $ticketAssignee->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
 }
