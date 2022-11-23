<?php

declare(strict_types=1);

namespace App\Services\Tickets\Validations\Rules;

use App\Enum\ServicesEnum;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\InvalidExtraException;
use App\Services\Tickets\Interfaces\Resolvers\ServiceExtraResolverInterface;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;

final class ValidExtrasRuleService implements TicketEventServiceValidationRuleInterface
{
    public function __construct(ServiceExtraResolverInterface $serviceExtraResolver)
    {
        $this->serviceExtraResolver = $serviceExtraResolver;
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidExtraException
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool
    {
        $serviceExtras = $service->getExtras();

        foreach ($extras as $extra) {
            if(\in_array($extra['name'], $serviceExtras) === true) {
                continue;
            }

            throw new InvalidExtraException(
                \sprintf(
                    '%s not found.',
                    $extra['name']
                )
            );
        }

        return true;
    }
}
