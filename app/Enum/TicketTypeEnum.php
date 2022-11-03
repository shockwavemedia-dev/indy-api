<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const EMAIL = 'email';

    /**
     * @var string
     */
    public const EVENT = 'event';

    /**
     * @var string
     */
    public const LIBRARY = 'library';

    /**
     * @var string
     */
    public const GRAPHIC = 'graphic';

    /**
     * @var string
     */
    public const PRINT = 'print';

    /**
     * @var string
     */
    public const TASK = 'task';
}
