<?php

declare(strict_types=1);

namespace App\Enum;


final class ClientRoleEnum extends UserRoleEnum
{
    /**
     * @var string
     */
    public const MARKETING = 'marketing';

    /**
     * @var string
     */
    public const MARKETING_MANAGER = 'marketing manager';

    /**
     * @var string
     */
    public const GROUP_MANAGER = 'group manager';
}
