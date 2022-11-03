<?php

declare(strict_types=1);

namespace App\Http\Resources\API\ClientServices;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Client;
use App\Models\ClientService;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;

final class ClientServiceResource extends Resource
{
    /**
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof ClientService) === false) {
            throw new InvalidResourceTypeException(ClientService::class);
        }

        /** @var ClientService $clientService */
        $clientService = $this->resource;

        $service = $clientService->getService();

        return [
            'id' => $clientService->getId(),
            'service_id' => $service->getId(),
            'service_name' => $service->getName(),
            'marketing_quota' => $clientService->getMarketingQuota(),
            'extra_quota' => $clientService->getExtraQuota(),
            'total_used' => $clientService->getTotalUsed(),
            'is_enabled' => $clientService->isEnabled(),
            'extras' => $clientService->getExtras(),
            'created_by' => \sprintf(
                '%s %s %s',
                $clientService->getCreatedBy()->getFirstName(),
                $clientService->getCreatedBy()->getMiddleName(),
                $clientService->getCreatedBy()->getLastName(),
            ),
            'updated_by' => \sprintf(
                '%s %s %s',
                $clientService->getUpdatedBy()?->getFirstName(),
                $clientService->getUpdatedBy()?->getMiddleName(),
                $clientService->getUpdatedBy()?->getLastName(),
            )
        ];
    }
}
