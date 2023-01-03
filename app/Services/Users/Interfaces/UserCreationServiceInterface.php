<?php

namespace App\Services\Users\Interfaces;

use App\Models\User;
use App\Services\Users\Resources\CreateUserResource;

interface UserCreationServiceInterface
{
    public function create(CreateUserResource $resource): User;
}
