<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const CLOSED = 'closed';

    /**
     * @var string
     */
    public const NEW = 'new';

    /**
     * @var string
     */
    public const PENDING = 'pending';

    /**
     * @var string
     */
    public const OPEN = 'open';

    public const IN_PROGRESS = 'in_progress';

    /**
     * @var string
     */
    public const DELETED = 'deleted';
}
