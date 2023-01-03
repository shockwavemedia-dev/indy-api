<?php

namespace App\Services\Notifications\Interfaces;

use App\Models\User;

interface GenericNotificationSenderResolverInterface
{
    public function resolve(
        User $user,
        mixed $object,
        string $message,
        string $link,
        string $subject
    ): void;
}
