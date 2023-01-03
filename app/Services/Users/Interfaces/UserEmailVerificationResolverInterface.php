<?php

namespace App\Services\Users\Interfaces;

use App\Models\User;

interface UserEmailVerificationResolverInterface
{
    public function resolve(User $user): void;
}
