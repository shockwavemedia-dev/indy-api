<?php

namespace App\Services\BackendUserNotifications\Interfaces;

use App\Enum\BackendUserNotificationTypeEnum;

interface BackendUserNotificationResolverFactoryInterface
{
    public function make(BackendUserNotificationTypeEnum $typeEnum): BackendUserNotificationResolverInterface;
}
