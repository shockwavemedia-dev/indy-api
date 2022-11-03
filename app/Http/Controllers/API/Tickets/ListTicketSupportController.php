<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Helpers\Interfaces\ArrayHelperInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\TicketQueryRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketSupportController extends AbstractAPIController
{
    private ArrayHelperInterface $arrayHelper;

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(ArrayHelperInterface $arrayHelper, TicketRepositoryInterface $ticketRepository)
    {
        $this->arrayHelper = $arrayHelper;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(TicketQueryRequest $request): JsonResource
    {
        $statuses = $request->getStatuses() ?? [];
        $types = $request->getTypes() ?? [];

        $statusCheck = $this->arrayHelper->arrayDiff($statuses, TicketStatusEnum::toArray());
        $typesCheck = $this->arrayHelper->arrayDiff($types, TicketTypeEnum::toArray());

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

        $options = [
            'department_ids' => $request->getDepartmentIds(),
            'status' => $statuses,
            'types' => $types
        ];

        try {
            $tickets = $this->ticketRepository->findByOptions(
                $options,
                $request->getSize(),
                $request->getPageNumber(),
            );

            return new TicketSupportsResource($tickets);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
