<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketNotificationTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const ASSIGNED = 'assigned';

    /**
     * @var string
     */
    public const CREATED = 'created';

    /**
     * @var string
     */
    public const UPDATED = 'updated';
}
