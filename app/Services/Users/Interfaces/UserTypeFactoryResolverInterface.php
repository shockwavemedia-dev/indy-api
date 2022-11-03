<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\UserTypeEnum;
use App\Models\Users\Interfaces\UserTypeInterface;

interface UserTypeFactoryResolverInterface
{
    public function make(UserTypeEnum $userType): UserTypeFactoryInterface;
}
