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
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketSupportController extends AbstractAPIController
{
    public function __construct(
        private ArrayHelperInterface $arrayHelper,
        private TicketRepositoryInterface $ticketRepository,
    ) {
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

        $user = $this->getUser();

        if ($user->getUserType() instanceof ClientUser === true) {
            $client = $user->getUserType()->getClient();
        }

        try {
            $tickets = $this->ticketRepository->findByOptions(
                new TicketFilterOptionsResource([
                    'clientId' => $request->getClientId(),
                    'departmentIds' => $request->getDepartmentIds(),
                    'statuses' => $statuses,
                    'priorities' => $priorities,
                    'hideClosed' => $request->hideClosed(),
                    'code' => $request->getCode(),
                    'deadline' => $request->getDeadline(),
                    'types' => $types,
                    'subject' => $request->getSubject(),
                ]),
                $request->getSize(),
                $request->getPageNumber(),
            );

            return new TicketSupportsResource($tickets);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
