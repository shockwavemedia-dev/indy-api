<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Factories;

use App\Models\Tickets\TicketEvent;
use App\Services\Tickets\Factories\TicketEventAttachmentFactory;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;
use Tests\Stubs\Repositories\TicketEventAttachmentRepositoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Tickets\Factories\TicketEventAttachmentFactory
 */
final class TicketEventAttachmentFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $ticket = $this->env->ticket;

        $ticketEvent = new TicketEvent();
        $ticketEvent->setAttribute('id', 1);
        $ticketEvent->ticket()->associate($ticket);
        $ticketEvent->save();

        $file = $this->env->file;

        $ticketEventAttachmentRepository = new TicketEventAttachmentRepositoryStub([
            'create' => $this->env->ticketEventAttachment([
                'ticket_event_id' => $ticketEvent->getId(),
                'file_id' => $file->getId(),
            ])->ticketEventAttachment,
        ]);

        $factory = new TicketEventAttachmentFactory($ticketEventAttachmentRepository);

        $factory->make(new CreateTicketEventAttachmentResource([
            'ticketEvent' => $ticketEvent,
            'file' => $file,
        ]));

        self::assertEquals([
            [
                'create' => [
                    [
                        'file_id' => $file->getId(),
                        'ticket_event_id' => $ticketEvent->getId(),
                    ],
                ],
            ],
        ], $ticketEventAttachmentRepository->getCalls());
    }
}
