<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class DepartmentStatusEnum extends Enum
{
    /**
     * @var string
     */
    public const ACTIVE = 'active';

    /**
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * @var string
     */
    public const INACTIVE = 'inactive';
}
