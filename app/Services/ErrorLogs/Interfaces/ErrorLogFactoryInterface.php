<?php

namespace App\Services\ErrorLogs\Interfaces;

use App\Models\ErrorLog;
use App\Services\ErrorLogs\Resources\CreateErrorLogResource;

interface ErrorLogFactoryInterface
{
    public function make(CreateErrorLogResource $resource): ErrorLog;
}
