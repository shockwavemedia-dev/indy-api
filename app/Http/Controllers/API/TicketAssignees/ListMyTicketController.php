<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListMyTicketController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        try {
            /** @var AdminUser $adminUser */
            $adminUser = $this->getUser()->getUserType();

            $tickets = $this->ticketRepository->findByAssigneeAdminUser(
                $adminUser,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new TicketSupportsResource($tickets);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
