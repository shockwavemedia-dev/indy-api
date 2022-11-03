<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Users\LeadClient;
use App\Repositories\Interfaces\LeadClientRepositoryInterface;

final class LeadClientRepository extends BaseRepository implements LeadClientRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new LeadClient());
    }
}
