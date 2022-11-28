<?php

declare(strict_types=1);

namespace App\Enum;

final class AdminRoleEnum extends UserRoleEnum
{
    /**
     * @var string
     */
    public const ACCOUNT_MANAGER = 'account manager';

    /**
     * @var string
     */
    public const ADMIN = 'admin';

    /**
     * @var string
     */
    public const MANAGER = 'manager';

    /**
     * @var string
     */
    public const STAFF = 'staff';

    /**
     * @var string
     */
    public const PRINT_MANAGER = 'print manager';
}
