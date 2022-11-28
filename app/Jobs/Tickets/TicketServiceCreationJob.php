<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Enum\ServicesEnum;
use App\Enum\TicketNotificationTypeEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\ClientService;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Repositories\Interfaces\TicketServiceRepositoryInterface;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotifyDepartmentsResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class TicketServiceCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ClientService $clientService;

    private array $service;

    private Ticket $ticket;

    public function __construct(
        ClientService $clientService,
        Ticket $ticket,
        array $service
    ) {
        $this->clientService = $clientService;
        $this->service = $service;
        $this->ticket = $ticket;
    }

    // TODO convert this to a service and call the service here
    public function handle(
        ClientServiceRepositoryInterface $clientServiceRepository,
        DesignatorResolverFactoryInterface $designatorResolverFactory,
        ErrorLogInterface $sentryHandler,
        TicketNotifyDepartmentsResolverInterface $notifyDepartmentsResolver,
        TicketServiceRepositoryInterface $ticketServiceRepository
    ): void {
        try {
            $ticketServiceRepository->create($this->service);

            $clientServiceRepository->increaseTotalUsageByClientService($this->clientService);

            $service = $this->clientService->getService();

            $designatorResolver = $designatorResolverFactory->make(ServicesEnum::from($service->getName()));

            $designatorResolver->resolve($this->ticket);

            $notifyDepartmentsResolver->resolve(
                $this->ticket->refresh(),
                new TicketNotificationTypeEnum(TicketNotificationTypeEnum::CREATED)
            );
        } catch (\Throwable $throwable) {
            $sentryHandler->reportError($throwable);
            $sentryHandler->log(\json_encode($this->service));
        }
    }
}
