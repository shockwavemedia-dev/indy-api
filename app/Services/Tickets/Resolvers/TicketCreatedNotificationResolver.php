<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resolvers;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotificationResolverInterface;
use function ucfirst;

final class TicketCreatedNotificationResolver extends AbstractTicketNotificationResolver implements TicketNotificationResolverInterface
{
    /**
     * @throws \Exception
     */
    public function resolve(Ticket $ticket, User $user): void
    {
        $this->sendNotification($ticket, $user);
    }

    public function supports(TicketNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === TicketNotificationTypeEnum::CREATED;
    }

    /**
     * @throws \Exception
     */
    protected function getMessage(Ticket $ticket, User $user, string $url): string
    {
        return sprintf(
            'Hi %s, %s Ticket %s has been created. You may check the link here %s',
            $user->getFirstName(),
            ucfirst($ticket->getType()->getValue()),
            $ticket->getTicketCode(),
            $url
        );
    }

    protected function getNotificationTitle(Ticket $ticket): string
    {
        return sprintf(
            '%s Ticket %s has been created.',
            ucfirst($ticket->getType()->getValue()),
            $ticket->getTicketCode(),
        );
    }
}
