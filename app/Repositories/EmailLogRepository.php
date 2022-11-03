<?php

namespace App\Repositories;

use App\Models\Emails\EmailLog;
use App\Repositories\Interfaces\EmailLogRepositoryInterface;

final class EmailLogRepository extends BaseRepository implements EmailLogRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new EmailLog());
    }
}
