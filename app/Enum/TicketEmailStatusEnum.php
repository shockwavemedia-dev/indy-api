<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketEmailStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const SUCCESS = 'success';

    /**
     * @var string
     */
    public const FAILED = 'failed';

    /**
     * @var string
     */
    public const PENDING = 'pending';
}
