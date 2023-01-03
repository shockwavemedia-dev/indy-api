<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\UserTypeEnum;

interface UserTypeFactoryResolverInterface
{
    public function make(UserTypeEnum $userType): UserTypeFactoryInterface;
}
