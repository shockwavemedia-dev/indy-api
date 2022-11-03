<?php

declare(strict_types=1);

 namespace Tests\Unit\Models;

 use App\Enum\TicketEmailStatusEnum;
 use App\Enum\UserTypeEnum;
 use App\Models\Tickets\TicketEmail;
 use PHPUnit\Framework\TestCase;

 /**
  * @covers \App\Models\Tickets\TicketEmail
  */
 final class TicketEmailTest extends TestCase
 {
     public function testGetterAndSetters(): void
    {

        $expected = [
            'id' => 1,
            'client_id' => 1,
            'ticket_id' => 1,
            'cc' => 'test@test.com',
            'message' => 'Please update the logo color to #ffff',
            'sender_by' => 1,
            'sender_type' => UserTypeEnum::ADMIN,
            'updated_by' => 1,
            'is_read' => false,
            'status' => TicketEmailStatusEnum::PENDING,
        ];

        $ticketEmail = new TicketEmail();
        $ticketEmail->setAttribute('id', 1);
        $ticketEmail->setAttribute('client_id', 1);
        $ticketEmail->setAttribute('ticket_id', 1);
        $ticketEmail->setCc('test@test.com');
        $ticketEmail->setMessage('Please update the logo color to #ffff');
        $ticketEmail->setAttribute('sender_by', 1);
        $ticketEmail->setAttribute('sender_type', UserTypeEnum::ADMIN);
        $ticketEmail->setAttribute('updated_by', 1);
        $ticketEmail->markAsRead(false);
        $ticketEmail->setStatus(new TicketEmailStatusEnum(TicketEmailStatusEnum::PENDING));

        $actual = [
            'id' => $ticketEmail->getId(),
            'client_id' => $ticketEmail->getClientId(),
            'ticket_id' => $ticketEmail->getTicketId(),
            'cc' => $ticketEmail->getCc(),
            'message' => $ticketEmail->getMessage(),
            'sender_by' => $ticketEmail->getSenderById(),
            'sender_type' => $ticketEmail->getSenderType(),
            'updated_by' => $ticketEmail->getUpdatedById(),
            'is_read' => $ticketEmail->IsRead(),
            'status' => $ticketEmail->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
 }
