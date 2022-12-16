<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListMyTicketController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        try {
            /** @var AdminUser $adminUser */
            $adminUser = $this->getUser()->getUserType();

            $client = null;

            if($request->getClientId() !== null){
                $client = $this->clientRepository->find($request->getClientId());

                if ($client === null) {
                    return $this->respondNotFound([
                        'message' => 'Client not found.',
                    ]);
                }
            }

            $tickets = $this->ticketRepository->findByAssigneeAdminUser(
                $adminUser,
                new TicketFilterOptionsResource([
                    'statuses' => $request->getStatuses(),
                    'priorities' => $request->getPriorities(),
                ]),
                $client,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new TicketSupportsResource($tickets);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
