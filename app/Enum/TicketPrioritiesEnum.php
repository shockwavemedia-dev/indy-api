<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketPrioritiesEnum extends Enum
{
    /**
     * 1 week
     *
     * @var string
     */
    public const RELAXED = 'Relaxed';

    /**
     * 48 hours
     *
     * @var string
     */
    public const STANDARD = 'Standard';

    /**
     * 24 hours
     *
     * @var string
     */
    public const URGENT = 'Urgent';
}
