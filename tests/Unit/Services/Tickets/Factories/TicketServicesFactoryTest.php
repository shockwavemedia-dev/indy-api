<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Factories;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Jobs\Tickets\TicketServiceCreationJob;
use App\Models\ClientService;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\Tickets\Factories\TicketServicesFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * @covers \App\Services\Tickets\Factories\TicketServicesFactory
 */
final class TicketServicesFactoryTest extends TestCase
{
    /**
     * @throws \App\Services\Tickets\Exceptions\UnsupportedTicketTypeException
     */
    public function testMakeSuccess(): void
    {
        $clientServiceCollection = new Collection();
        $clientService = new ClientService();
        $clientService->setAttribute('service_id', 1);
        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);

        $clientServiceCollection->add($clientService);

        $adminUser = new AdminUser();
        $createdBy = new User();
        $createdBy->setRelation('userType', $adminUser);
        $createdBy->setAttribute('id', 1);
        $services = [
            [
                'service_id' => 1,
                'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
            ],
            [
                'service_id' => 2,
                'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
            ],
        ];

        $factory = new TicketServicesFactory();

        self::expectsJobs(TicketServiceCreationJob::class);

        $factory->make(
            $clientServiceCollection,
            $ticket,
            $createdBy,
            $services,
        );
    }
}
