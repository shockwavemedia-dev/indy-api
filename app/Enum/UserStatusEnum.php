<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class UserStatusEnum extends Enum
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
    public const GUEST = 'guest';

    /**
     * @var string
     */
    public const INACTIVE = 'inactive';

    /**
     * @var string
     */
    public const INVITED = 'invited';

    /**
     * @var string
     */
    public const REVOKED = 'revoked';
}
