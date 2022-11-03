<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications\NotificationResolvers;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\SupportRequest;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class SupportRequestNotificationResolver extends AbstractBackendUserNotificationResolver implements BackendUserNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = 'Support Request created by client %s';

    private AdminUserRepositoryInterface $adminUserRepository;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory
    ) {
        parent::__construct($notificationFactory, $notificationUserFactory);

        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @param SupportRequest $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $managers = $this->adminUserRepository->findAccountManagersByDepartment($morph->getDepartment());

        /** @var AdminUser $manager */
        foreach ($managers as $manager) {
            $this->resolveNotification($morph, $manager->getUser());
        }
    }

    /**
     * @param SupportRequest $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function resolveNotification(mixed $morph, User $user): void
    {
        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => null,
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getClient()->getName(),
            ),
        ]);

        $this->saveNotification($notificationResource, $user);
    }

    public function supports(BackendUserNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === BackendUserNotificationTypeEnum::SUPPORT_REQUEST;
    }
}
