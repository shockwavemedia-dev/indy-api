<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class NotificationStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * @var string
     */
    public const NEW = 'new';

    /**
     * @var string
     */
    public const READ = 'read';
}
