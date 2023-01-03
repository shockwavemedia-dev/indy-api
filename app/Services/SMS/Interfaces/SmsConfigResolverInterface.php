<?php

namespace App\Services\SMS\Interfaces;

use App\Services\SMS\Resources\SmsConfigResource;

interface SmsConfigResolverInterface
{
    public function resolve(): SmsConfigResource;
}
