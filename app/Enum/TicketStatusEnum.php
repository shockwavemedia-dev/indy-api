<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const DECLINED = 'declined';

    /**
     * @var string
     */
    public const REQUEST_REVISION = 'request revision';

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
    public const ON_HOLD = 'on hold';

    /**
     * @var string
     */
    public const OPEN = 'open';

    /**
     * @var string
     */
    public const RESOLVED = 'resolved';

    /**
     * @var string
     */
    public const DELETED = 'deleted';
}
