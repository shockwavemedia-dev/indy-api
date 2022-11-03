<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class SupportRequestStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const CLOSED = 'closed';

    /**
     * @var string
     */
    public const PENDING = 'pending';

    /**
     * @var string
     */
    public const NEW = 'new';
}
