<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Interfaces\Validations;

use App\Models\Client;

interface ClientServicesValidatorInterface
{
    public function validate(Client $client, array $services): bool;
}
