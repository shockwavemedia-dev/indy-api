<?php

namespace App\Services\ClientUserNotifications\Interfaces;

use App\Enum\ClientNotificationTypeEnum;

interface ClientNotificationResolverFactoryInterface
{
    public function make(ClientNotificationTypeEnum $typeEnum): ClientNotificationResolverInterface;
}
