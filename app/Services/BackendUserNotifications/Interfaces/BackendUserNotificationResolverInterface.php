<?php

namespace App\Services\BackendUserNotifications\Interfaces;

use App\Enum\BackendUserNotificationTypeEnum;

interface BackendUserNotificationResolverInterface
{
    public function resolve(mixed $morph): void;

    public function supports(BackendUserNotificationTypeEnum $typeEnum): bool;
}
