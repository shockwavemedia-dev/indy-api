<?php

namespace App\Services\EmailLogs\Interfaces;

use App\Models\Emails\EmailLog;
use App\Services\EmailLogs\resources\CreateEmailLogResource;

interface EmailLogFactoryInterface
{
    public function make(CreateEmailLogResource $resource): EmailLog;
}
