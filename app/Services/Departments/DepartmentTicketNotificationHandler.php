<?php

declare(strict_types=1);

namespace App\Services\Departments;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\Tickets\Interfaces\Factories\TicketNotificationResolverFactoryInterface;

final class DepartmentTicketNotificationHandler implements DepartmentTicketNotificationHandlerInterface
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private TicketNotificationResolverFactoryInterface $ticketNotificationResolverFactory;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        TicketNotificationResolverFactoryInterface $ticketNotificationResolverFactory
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->ticketNotificationResolverFactory = $ticketNotificationResolverFactory;
    }

    public function handle(
        Department $department,
        Ticket $ticket,
        TicketNotificationTypeEnum $typeEnum
    ): void {
        $accountManagers = $this->adminUserRepository->findAccountManagersByDepartment($department);

        $notificationResolver = $this->ticketNotificationResolverFactory->make($typeEnum);

        /** @var AdminUser $accountManager */
        foreach ($accountManagers as $accountManager) {
            $notificationResolver->resolve($ticket, $accountManager->getUser());
        }
    }
}
