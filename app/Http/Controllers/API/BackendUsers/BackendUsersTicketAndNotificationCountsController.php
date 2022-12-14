<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\BackendUsers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;

final class BackendUsersTicketAndNotificationCountsController extends AbstractAPIController
{
    private NotificationUserRepositoryInterface $notificationUserRepository;

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        NotificationUserRepositoryInterface $notificationUserRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->notificationUserRepository = $notificationUserRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke()
    {
        /** @var \App\Models\User $user */
        $user = $this->getUser();

        if ($user->getUserType() instanceof AdminUser === false) {
            return $this->respondForbidden(['message' => 'You do not have access to this.']);
        }

        /** @var \App\Models\Users\AdminUser $adminUser */
        $adminUser = $user->getUserType();

        $department = $adminUser->getDepartments()->first();

        return response()->json([
            'new_ticket_count' => $adminUser->countNewTickets(),
            'open_ticket_count' => $adminUser->countPendingTickets(),
            'new_notification_count' => $this->notificationUserRepository->countNewNotificationByUser($user),
        ]);
    }
}
