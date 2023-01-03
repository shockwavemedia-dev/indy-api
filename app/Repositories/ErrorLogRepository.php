<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ErrorLog;
use App\Repositories\Interfaces\ErrorLogRepositoryInterface;

final class ErrorLogRepository extends BaseRepository implements ErrorLogRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ErrorLog());
    }
}
