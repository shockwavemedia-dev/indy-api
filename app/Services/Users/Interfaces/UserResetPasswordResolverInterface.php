<?php

namespace App\Services\Users\Interfaces;

use App\Models\User;

interface UserResetPasswordResolverInterface
{
    public function resolve(User $user, string $token): void;
}
