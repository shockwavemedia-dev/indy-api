<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\UserStatusEnum;
use App\Models\User;

interface RevokeUserServiceInterface
{
    public function revoke(User $user, UserStatusEnum $status): void;
}
