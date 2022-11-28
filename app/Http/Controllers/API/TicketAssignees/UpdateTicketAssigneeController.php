<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Enum\ClientNotificationTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\UpdateTicketAssigneeRequest;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Jobs\Tickets\TicketAssigneeLinkJob;
use App\Models\Tickets\TicketAssignee;
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

        $adminUser = null;
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

            $status = null;
            $notificationResolver = null;

            if ($ticketAssignee->getStatus() !== $request->getStatus()) {
                $notificationResolver = $this->clientNotificationResolverFactory
                    ->make(new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_ASSIGNEE_STATUS));

                $status = $request->getStatus();
            }

            $ticketAssignee = $this->ticketAssigneeRepository->update(
                $ticketAssignee,
                new UpdateTicketAssigneeResource([
                    'adminUser' => $adminUser,
                    'statusEnum' => $status,
                ]),
                $this->getUser()->getUserType(),
            );

            $notificationResolver?->resolve($ticketAssignee);

            return new TicketAssigneeResource($ticketAssignee);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
