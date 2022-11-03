<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketFileStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const APPROVED = 'approved';

    /**
     * @var string
     */
    public const BACK_FROM_REVIEW = 'back from review';

    /**
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * @var string
     */
    public const IN_PROGRESS = 'in progress';

    /**
     * @var string
     */
    public const FOR_REVIEW = 'for review';

    /**
     * @var string`
     */
    public const NEW = 'new';
}
