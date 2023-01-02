<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Interfaces\Validations;

use App\Models\ClientService;
use App\Models\Service;

interface ClientServiceValidationRuleInterface
{
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool;
}
