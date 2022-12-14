<?php

namespace App\Services\TicketAssignee\Resolvers;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\ServicesEnum;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverInterface;

final class PrinterManagerDesignatorResolver implements DesignatorResolverInterface
{
    public function __construct(
        private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        private TicketAssigneeRepositoryInterface $ticketRepository
    ) {
    }

    public function resolve(Ticket $ticket): void
    {
        if ($ticket->getClient()?->getDesignatedPrinterManager() === null) {
            return;
        }

        $checkTicketAssignee = $this->ticketRepository->findByAdminUserAndTicket(
            $ticket,
            $ticket->getClient()->getDesignatedPrinterManager()
        );

        if ($checkTicketAssignee !== null) {
            return;
        }

        /** @var User $superAdminUser */
        $superAdminUser = User::find(1);

        /** @var AdminUser $superAdminUserType */
        $superAdminUserType = $superAdminUser->getUserType();

        $ticketAssignee = $this->ticketRepository->assignTicket(
            $ticket->getClient()->getDesignatedPrinterManager(),
            $superAdminUserType,
            $ticket
        );

        $notificationResolver = $this->backendUserNotificationResolverFactory->make(
            new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::ASSIGNED_TICKET),
        );

        $notificationResolver->resolve($ticketAssignee);
    }

    public function supports(ServicesEnum $serviceType): bool
    {
        return $serviceType->getValue() === ServicesEnum::PRINT;
    }
}
