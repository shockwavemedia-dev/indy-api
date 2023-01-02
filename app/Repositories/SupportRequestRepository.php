<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SupportRequest;
use App\Repositories\Interfaces\SupportRequestRepositoryInterface;

final class SupportRequestRepository extends BaseRepository implements SupportRequestRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new SupportRequest());
    }
}
