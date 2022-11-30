<?php

declare(strict_types=1);

namespace Tests\Unit\Services\TicketNotes;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;
use App\Services\TicketNotes\TicketNoteFactory;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\TicketNoteRepositoryStub;

/**
 * @covers \Database\Factories\Tickets\TicketNoteFactory
 */
final class TicketNoteFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $ticketNote = new TicketNote();

        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);

        $createdBy = new User();
        $createdBy->setAttribute('id', 1);

        $repository = new TicketNoteRepositoryStub([
            'create' => $ticketNote,
        ]);

        $factory = new TicketNoteFactory($repository);

        $resource = new CreateTicketNoteResource([
            'ticket' => $ticket,
            'createdBy' => $createdBy,
            'note' => 'test note',
        ]);

        $factory->make($resource);

        self::assertEquals([
            [
                'create' => [
                    [
                        'ticket_id' => $ticket->getId(),
                        'created_by' => $createdBy->getId(),
                        'note' => 'test note',
                    ],
                ],
            ],
        ],
            $repository->getCalls());
    }
}
