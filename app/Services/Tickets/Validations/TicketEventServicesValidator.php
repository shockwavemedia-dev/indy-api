<?php

declare(strict_types=1);

namespace App\Services\Tickets\Validations;

use App\Models\Client;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\Tickets\Exceptions\ClientEmptyServicesException;
use App\Services\Tickets\Exceptions\InvalidServiceException;
use App\Services\Tickets\Interfaces\Validations\TicketEventServicesValidatorInterface;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;
use EonX\EasyUtils\CollectorHelper;
use Illuminate\Support\Arr;

final class TicketEventServicesValidator implements TicketEventServicesValidatorInterface
{
    private ServiceRepositoryInterface $serviceRepository;

    /**
     * @var \App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface[]
     */
    private array $rules;

    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        iterable $rules
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->rules = CollectorHelper::filterByClassAsArray(
            $rules,
            TicketEventServiceValidationRuleInterface::class
        );
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function validate(Client $client, array $services): bool
    {
        $validServices = $this->serviceRepository->findByIds(
            \array_column($services, 'service_id')
        );

        if ($validServices->count() !== \count($services)) {
            throw new InvalidServiceException('Service provided was invalid.');
        }

        $clientServices = $client->getClientServices();

        if (\count($clientServices) === 0) {
            throw new ClientEmptyServicesException('Client does not have services configured.');
        }

        foreach ($services as $service) {
            /** @var \App\Models\Service $validService */
            $validService = $validServices->find(Arr::get($service, 'service_id'));

            /** @var \App\Models\ClientService $clientService */
            $clientService = $clientServices->firstWhere('service_id', '=', $validService->getId());

            if ($clientService === null) {
                throw new ClientEmptyServicesException('Client does not have services configured.');
            }

            foreach ($this->rules as $rule) {
                $rule->validate(
                    $clientService,
                    $validService,
                    Arr::get($service, 'extras', [])
                );
            }
        }

        return true;
    }
}
