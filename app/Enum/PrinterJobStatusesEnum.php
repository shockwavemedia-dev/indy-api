<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class PrinterJobStatusesEnum extends Enum
{
    /**
     * @var string
     */
    public const FOR_QUOTATION = 'Awaiting Quote';

    /**
     * @var string
     */
    public const FOR_APPROVAL = 'Awaiting Approval';

    /**
     * @var string
     */
    public const IN_PROGRESS = 'In Progress';

    /**
     * @var string
     */
    public const TODO = 'Todo';

    /**
     * @var string
     */
    public const PENDING = 'Pending';

    /**
     * @var string
     */
    public const COMPLETED = 'Completed';

    /**
     * @var string
     */
    public const CANCELLED = 'Cancelled';
}
