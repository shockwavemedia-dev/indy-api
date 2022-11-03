<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Validations\Rules;

use App\Models\ClientService;
use App\Models\Service;
use App\Services\ClientServices\Interfaces\Validations\ClientServiceValidationRuleInterface;
use App\Services\Tickets\Exceptions\InvalidExtraException;

final class ValidExtrasRuleService implements ClientServiceValidationRuleInterface
{
    /**
     * @throws InvalidExtraException
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool
    {
        $serviceExtras = $service->getExtras();

        foreach ($extras as $extra) {
            if(\in_array($extra, $serviceExtras) === true) {
                continue;
            }

            throw new InvalidExtraException(
                \sprintf(
                    '%s not found.',
                    $extra
                )
            );
        }
        return true;
    }
}
