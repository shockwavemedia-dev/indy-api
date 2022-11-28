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

    final class DesignerDesignatorResolver implements DesignatorResolverInterface
    {
        public function __construct(
            private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
            private TicketAssigneeRepositoryInterface $ticketRepository
        ) {
        }

        public function resolve(Ticket $ticket): void
        {
            if ($ticket->getClient()?->getDesignatedDesigner() === null) {
                return;
            }

            $checkTicketAssignee = $this->ticketRepository->findByAdminUserAndTicket(
                $ticket,
                $ticket->getClient()->getDesignatedDesigner()
            );

            if ($checkTicketAssignee !== null) {
                return;
            }

            /** @var User $superAdminUser */
            $superAdminUser = User::find(1);

            /** @var AdminUser $superAdminUserType */
            $superAdminUserType = $superAdminUser->getUserType();

            $ticketAssignee = $this->ticketRepository->assignTicket(
                $ticket->getClient()->getDesignatedDesigner(),
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
            return $serviceType->getValue() === ServicesEnum::GRAPHIC_DESIGN;
        }
    }
