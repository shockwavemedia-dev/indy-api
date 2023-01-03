<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\TicketNote;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\Notifications\Interfaces\GenericNotificationSenderResolverInterface;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketNoteNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    public function __construct(
        protected GenericNotificationSenderResolverInterface $genericNotificationSenderResolver,
        protected EmailLogFactoryInterface $emailLogFactory,
        protected NotificationFactoryInterface $notificationFactory,
        protected NotificationUserFactoryInterface $notificationUserFactory
    ) {
        parent::__construct($emailLogFactory, $notificationFactory, $notificationUserFactory);
    }

    /**
     * @var string
     */
    private const TITLE_KEY = '%s has posted a message in ticket # %s';

    /**
     * @param  TicketNote  $morph
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $ticketCreator = $morph->getTicket()->getCreatedBy();

        if ($morph->getCreatedBy()->getId() === $ticketCreator->getId()) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/%s', $morph->getTicketId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getCreatedBy()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $ticketCreator);

        $this->genericNotificationSenderResolver->resolve(
            $ticketCreator,
            $morph,
            $notificationResource->getTitle(),
            $notificationResource->getLink(),
            'Posted Ticket Message'
        );
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::TICKET_NOTES;
    }
}
