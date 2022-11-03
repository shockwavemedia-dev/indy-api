<?php

namespace App\Services\SMS\Interfaces;

interface SmsClientInterface
{
    public function makeRequest(string $method, string $url, ?array $options = null): array;
}
