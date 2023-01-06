<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Enum\TicketAssigneeStatusEnum;
use App\Enum\TicketStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\UpdateTicketAssigneeRequest;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateTicketAssigneeStatusController extends AbstractAPIController
{
    public function __construct(
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

        try {
            if ($ticketAssignee->getStatus() === $request->getStatus()) {
                return new TicketAssigneeResource($ticketAssignee);
            }

            /** @var AdminUser $updatedBy */
            $updatedBy = $this->getUser()->getUserType();

            $ticketAssignee = $this->ticketAssigneeRepository->update(
                $ticketAssignee,
                new UpdateTicketAssigneeResource([
                    'statusEnum' => $request->getStatus(),
                ]),
                $updatedBy
            );

            $ticketAssignee->refresh();

            $ticket = $ticketAssignee->getTicket();

            $isAllComplete = false;

            // @TODO convert line 67-73 to a resolver service
            if ($ticketAssignee->getStatus()->getValue() === TicketAssigneeStatusEnum::COMPLETED) {
                $isAllComplete = $this->ticketAutoCompletion($ticket);
            }

            if ($isAllComplete === true) {
                return new TicketAssigneeResource($ticketAssignee);
            }

            if ($ticket->getStatus()->getValue() === TicketStatusEnum::NEW) {
                $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::IN_PROGRESS));
                $ticket->setUpdatedBy(null);
                $ticket->save();
            }

            return new TicketAssigneeResource($ticketAssignee);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function ticketAutoCompletion(Ticket $ticket): bool
    {
        $isAllComplete = true;

        /** @var TicketAssignee $assignee */
        foreach ($ticket->getTicketAssignees() as $assignee) {
            if ($assignee->getStatus()->getValue() !== TicketAssigneeStatusEnum::COMPLETED) {
                $isAllComplete = false;

                break;
            }
        }

        if ($isAllComplete === true) {
            $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::CLOSED));
            $ticket->save();
        }

        return $isAllComplete;
    }
}
