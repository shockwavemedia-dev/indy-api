<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class EmailStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const PENDING = 'pending';

    /**
     * @var string
     */
    public const SENT = 'sent';

    /**
     * @var string
     */
    public const FAILED = 'failed';
}
