<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\TicketAssignStaffsRequest;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\Tickets\Interfaces\AssignTicketServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;
use App\Models\Users\AdminUser;

final class TicketAssignStaffsController extends AbstractAPIController
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private AssignTicketServiceInterface $assignTicketService;

    private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory;

    private TicketRepositoryInterface $ticketRepository;

    private TicketAssigneeRepositoryInterface $ticketAssigneeRepository;


    public function __construct(
        AssignTicketServiceInterface $assignTicketService,
        AdminUserRepositoryInterface $adminUserRepository,
        BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        TicketRepositoryInterface $ticketRepository,
        TicketAssigneeRepositoryInterface $ticketAssigneeRepository
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->backendUserNotificationResolverFactory = $backendUserNotificationResolverFactory;
        $this->ticketRepository = $ticketRepository;
        $this->assignTicketService = $assignTicketService;
        $this->ticketAssigneeRepository = $ticketAssigneeRepository;
    }

    public function __invoke(int $id, TicketAssignStaffsRequest $request): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        $adminUser = $this->adminUserRepository->find($request->getAdminUserId());

        $checkTicketAssignee = $this->ticketAssigneeRepository->findByAdminUserAndTicket($ticket,$adminUser);

        if($checkTicketAssignee !== null){
            return $this->respondNoContent();
        }

        try {
            /** @var User $user */
            $user = $this->getUser();

            /** @var AdminUser $createdBy */
            $createdBy = $user->getUserType();

            $ticketAssignee = $this->assignTicketService->assign(
                $ticket,
                $adminUser,
                $createdBy,
                $request->getLinks(),
            );

            $notificationResolver = $this->backendUserNotificationResolverFactory->make(
                new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::ASSIGNED_TICKET),
            );

            $notificationResolver->resolve($ticketAssignee);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
