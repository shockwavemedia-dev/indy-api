<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Helpers\Interfaces\ArrayHelperInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\TicketQueryRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketSupportController extends AbstractAPIController
{
    private ArrayHelperInterface $arrayHelper;

    private TicketRepositoryInterface $ticketRepository;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        ArrayHelperInterface $arrayHelper,
        TicketRepositoryInterface $ticketRepository,
        ClientRepositoryInterface $clientRepository
    ){
        $this->arrayHelper = $arrayHelper;
        $this->ticketRepository = $ticketRepository;
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(TicketQueryRequest $request): JsonResource
    {
        $statuses = $request->getStatuses() ?? [];
        $types = $request->getTypes() ?? [];
        $priorities = $request->getPriorities() ?? [];

        $statusCheck = $this->arrayHelper->arrayDiff($statuses, TicketStatusEnum::toArray());
        $typesCheck = $this->arrayHelper->arrayDiff($types, TicketTypeEnum::toArray());
        $prioritiesCheck = $this->arrayHelper->arrayDiff($priorities, TicketPrioritiesEnum::toArray());

        if ($request->getStatuses() !== null && count($statusCheck) > 0) {
            return $this->respondBadRequest([
                'message' => 'Incorrect status provided',
            ]);
        }

        if ($request->getTypes() !== null && count($typesCheck) > 0) {
            return $this->respondBadRequest([
                'message' => 'Incorrect type provided',
            ]);
        }

        if ($request->getPriorities() !== null && count($prioritiesCheck) > 0) {
            return $this->respondBadRequest([
                'message' => 'Incorrect priority provided',
            ]);
        }

        $options = [
            'department_ids' => $request->getDepartmentIds(),
            'status' => $statuses,
            'types' => $types,
            'client_id' => $request->getClientId(),
            'priority' => $priorities,
        ];

        $client = null;

        if($request->getClientId() !== null){
            $client = $this->clientRepository->find($request->getClientId());

            if ($client === null) {
                return $this->respondNotFound([
                    'message' => 'Client not found.',
                ]);
            }
        }

        $user = $this->getUser();

        if ($user->getUserType() instanceof ClientUser === true) {
            $client = $user->getUserType()->getClient();
        }

        try {
            $tickets = $this->ticketRepository->findByOptions(
                $options,
                $request->getSize(),
                $request->getPageNumber(),
                $client,
            );

            return new TicketSupportsResource($tickets);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
