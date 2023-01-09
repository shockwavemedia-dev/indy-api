<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\UpdateTicketAssigneeRequest;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ReAssignTicketController extends AbstractAPIController
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository,
        private TicketAssigneeRepositoryInterface $ticketAssigneeRepository
    ) {
    }

    public function __invoke(UpdateTicketAssigneeRequest $request, int $id): JsonResource
    {
        /** @var TicketAssignee $ticketAssignee */
        $ticketAssignee = $this->ticketAssigneeRepository->find($id);

        if ($ticketAssignee === null) {
            return $this->respondNotFound([
                'message' => 'Assignee not found.',
            ]);
        }

        if ($request->getAdminUserId() !== null) {
            return new TicketAssigneeResource($ticketAssignee);
        }

        $newAdminUser = $this->adminUserRepository->find($request->getAdminUserId());

        $assigneeCheckIfExist = $this->ticketAssigneeRepository->findByAdminUserAndTicket(
            $ticketAssignee->getTicket(),
            $newAdminUser
        );

        if ($assigneeCheckIfExist !== null) {
            return new TicketAssigneeResource($ticketAssignee);
        }

        try {
            /** @var AdminUser $updatedBy */
            $updatedBy = $this->getUser()->getUserType();

            $ticketAssignee = $this->ticketAssigneeRepository->update(
                $ticketAssignee,
                new UpdateTicketAssigneeResource([
                    'adminUser' => $newAdminUser,
                ]),
                $updatedBy
            );

            return new TicketAssigneeResource($ticketAssignee);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
