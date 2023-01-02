<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketAssigneeStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const COMPLETED = 'completed';

    /**
     * @var string
     */
    public const IN_PROGRESS = 'in progress';

    /**
     * @var string
     */
    public const OPEN = 'open';
}
