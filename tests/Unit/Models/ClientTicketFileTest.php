<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\TicketFileStatusEnum;
use App\Models\Tickets\ClientTicketFile;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\ClientTicketFile
 */
final class ClientTicketFileTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'file_id' => 1,
            'client_id' => 1,
            'ticket_id' => 1,
            'description' => 'this is december logo',
            'admin_user_id' => 1,
            'approved_by' => 2,
            'status' => TicketFileStatusEnum::NEW,
        ];

        $clientTicketFile = new ClientTicketFile();
        $clientTicketFile->setAttribute('id', 1);
        $clientTicketFile->setAttribute('file_id', 1);
        $clientTicketFile->setAttribute('client_id', 1);
        $clientTicketFile->setAttribute('ticket_id', 1);
        $clientTicketFile->setAttribute('description', 'this is december logo');
        $clientTicketFile->setAttribute('admin_user_id', 1);
        $clientTicketFile->setAttribute('approved_by', 2);
        $clientTicketFile->setStatus(new TicketFileStatusEnum(TicketFileStatusEnum::NEW));

        $actual = [
            'id' => $clientTicketFile->getId(),
            'file_id' => $clientTicketFile->getFileId(),
            'client_id' => $clientTicketFile->getClientId(),
            'ticket_id' => $clientTicketFile->getTicketId(),
            'description' => $clientTicketFile->getDescription(),
            'admin_user_id' => $clientTicketFile->getAdminUserId(),
            'approved_by' => $clientTicketFile->getApprovedById(),
            'status' => $clientTicketFile->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
}
