<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Enum\TicketAssigneeStatusEnum;
use App\Enum\TicketStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\UpdateTicketAssigneeRequest;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Jobs\Tickets\TicketAssigneeLinkJob;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateTicketAssigneeController extends AbstractAPIController
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory;

    private TicketAssigneeRepositoryInterface $ticketAssigneeRepository;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        TicketAssigneeRepositoryInterface $ticketAssigneeRepository
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->clientNotificationResolverFactory = $clientNotificationResolverFactory;
        $this->ticketAssigneeRepository = $ticketAssigneeRepository;
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

        $checkTicketAssignee = null;

        if ($request->getAdminUserId() !== null) {
            $adminUser = $this->adminUserRepository->find($request->getAdminUserId());

            $checkTicketAssignee = $this->ticketAssigneeRepository->findByAdminUserAndTicket(
                $ticketAssignee->getTicket(),
                $adminUser
            );
        }

        if ($checkTicketAssignee !== null) {
            return new TicketAssigneeResource($ticketAssignee);
        }

        try {
            foreach ($request->getLinks() ?? [] as $link) {
                TicketAssigneeLinkJob::dispatch(
                    $this->getUser(),
                    $ticketAssignee,
                    Arr::get($link, 'ticket_assignee_id'),
                    Arr::get($link, 'issue'),
                );
            }

            $status = $ticketAssignee->getStatus();

            if ($status !== $request->getStatus()) {
                $status = $request->getStatus();
            }

            /** @var AdminUser $adminUser */
            $adminUser = $this->getUser()->getUserType();

            $ticketAssignee = $this->ticketAssigneeRepository->update(
                $ticketAssignee,
                new UpdateTicketAssigneeResource([
                    'adminUser' => $adminUser,
                    'statusEnum' => $status,
                ]),
                $adminUser
            );

            $ticket = $ticketAssignee->getTicket();

            $isAllComplete = false;

            if ($status->getValue() === TicketAssigneeStatusEnum::COMPLETED) {
                $isAllComplete = $this->ticketAutoCompletion($ticket);
            }

            if ($isAllComplete === true) {
                return new TicketAssigneeResource($ticketAssignee);
            }

            if ($ticket->getStatus()->getValue() !== TicketStatusEnum::IN_PROGRESS) {
                $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::IN_PROGRESS));

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
