<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class UserTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const ADMIN = 'admin_users';

    /**
     * @var string
     */
    public const CLIENT = 'client_users';

    /**
     * @var string
     */
    public const LEAD_CLIENT = 'lead_client';

    /**
     * @var string
     */
    public const PRINTER = 'printer';
}
