<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Jobs\Tickets\TicketServiceCreationJob;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

final class TicketServicesFactory implements TicketServicesFactoryInterface
{
    public function make(Collection $clientServices, Ticket $ticket, User $user, array $services): void
    {
        foreach ($services as $service) {
            $service['ticket_id'] = $ticket->getId();
            $service['created_by'] = $user->getId();

            $clientService = $clientServices
                ->firstWhere('service_id', '=', Arr::get($service, 'service_id'));

            if ($clientService === null) {
                continue;
            }

            TicketServiceCreationJob::dispatch($clientService, $ticket, $service);
        }
    }
}
