<?php

namespace App\Services\ClientUserNotifications\Interfaces;

use App\Enum\ClientNotificationTypeEnum;

interface ClientNotificationResolverInterface
{
    public function resolve(mixed $morph): void;

    public function supports(ClientNotificationTypeEnum $typeEnum): bool;
}
