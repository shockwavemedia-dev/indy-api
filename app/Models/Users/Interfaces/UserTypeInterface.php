<?php

declare(strict_types=1);

namespace App\Models\Users\Interfaces;

use App\Enum\UserTypeEnum;
use App\Models\User;

interface UserTypeInterface
{
    public function getRole(): string;

    public function setRole(string $role): self;

    public function getType(): UserTypeEnum;

    public function getUser(): ?User;
}
