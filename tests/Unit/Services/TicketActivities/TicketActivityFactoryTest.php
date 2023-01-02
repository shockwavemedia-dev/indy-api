<?php

declare(strict_types=1);

namespace Tests\Unit\Services\TicketActivities;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketActivity;
use App\Models\User;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;
use App\Services\TicketActivities\TicketActivityFactory;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\TicketActivityRepositoryStub;

/**
 * @covers \Database\Factories\Tickets\TicketActivityFactory
 */
final class TicketActivityFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $ticketActivity = new TicketActivity();

        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);

        $user = new User();
        $user->setAttribute('id', 1);

        $repository = new TicketActivityRepositoryStub([
            'create' => $ticketActivity,
        ]);

        $factory = new TicketActivityFactory($repository);

        $resource = new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $user,
            'activity' => 'test',
        ]);

        $factory->make($resource);

        self::assertEquals([
            [
                'create' => [
                    [
                        'ticket_id' => 1,
                        'user_id' => 1,
                        'activity' => 'test',
                    ],
                ],
            ],
        ],
            $repository->getCalls());
    }
}
