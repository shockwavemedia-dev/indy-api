<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientTicketFiles;

use App\Enum\TicketFileStatusEnum;
use App\Models\Client;
use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\Users\AdminUser;
use App\Services\ClientTicketFiles\Resources\CreateClientTicketFileResource;
use App\Services\ClientTicketFiles\TicketFileFactory;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ClientTicketFileRepositoryStub;

/**
 * @covers \App\Services\ClientTicketFiles\TicketFileFactory
 */
final class TicketFileFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $adminUser = new AdminUser();
        $adminUser->setAttribute('id', 1);

        $client = new Client();
        $client->setAttribute('id', 1);

        $file = new File();
        $file->setAttribute('id', 1);

        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);
        $ticket->setRelation('client', $client);

        $clientTicketFile = new ClientTicketFile();

        $repository = new ClientTicketFileRepositoryStub([
            'create' => $clientTicketFile
        ]);

        $factory = new TicketFileFactory($repository);

        $status = new TicketFileStatusEnum(TicketFileStatusEnum::NEW);

        $result = $factory->make(new CreateClientTicketFileResource([
            'file' => $file,
            'ticket' => $ticket,
            'statusEnum' => $status,
            'description' => null,
            'assignedStaff' => $adminUser,
        ]));

        self::assertEquals(
            [
                [
                    'create' => [
                        [
                            'file_id' => 1,
                            'client_id' => 1,
                            'ticket_id' => 1,
                            'status' => $status,
                            'description' => null,
                            'admin_user_id' => 1,
                            'approved_by' => null,
                            'approved_at' => null,
                        ]
                    ]
                ]
            ],
            $repository->getCalls(),
        );
    }
}
