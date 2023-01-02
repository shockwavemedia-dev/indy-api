<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

interface CreateUserTypeResourceInterface
{
    public function getRole(): string;
}
