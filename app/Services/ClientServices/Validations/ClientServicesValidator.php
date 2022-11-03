<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Validations;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\ClientServices\Interfaces\Validations\ClientServicesValidatorInterface;
use App\Services\ClientServices\Interfaces\Validations\ClientServiceValidationRuleInterface;
use App\Services\Tickets\Exceptions\InvalidServiceException;
use EonX\EasyUtils\CollectorHelper;
use Illuminate\Support\Arr;

final class ClientServicesValidator implements ClientServicesValidatorInterface
{
    private ServiceRepositoryInterface $serviceRepository;

    private array $rules;

    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        iterable $rules
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->rules = CollectorHelper::filterByClassAsArray(
            $rules,
            ClientServiceValidationRuleInterface::class
        );
    }

    /**
     * @throws InvalidServiceException
     */
    public function validate(Client $client, array $services): bool
    {
        $serviceIds = \array_column($services, 'service_id');

        $validServices = $this->serviceRepository->findByIds(
            $serviceIds
        );

        if ($validServices->count() !== \count($serviceIds)) {
            throw new InvalidServiceException('Service provided was invalid.');
        }

        /** @var ClientService $clientService */
        $clientServices = $client->getClientServices();

        foreach ($services as $service) {
            /** @var Service $validService */
            $validService = $validServices->find(Arr::get($service, 'service_id'));

            $clientService = $clientServices->where('service_id', '=' ,Arr::get($service, 'service_id'))->first();

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
