<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\ClientUserRepositoryInterface;

final class ClientUserRepository extends BaseRepository implements ClientUserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ClientUser());
    }
}
