<?php

declare(strict_types=1);

namespace App\Http\Resources\API\ClientServices;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\ClientService;

final class ClientServiceResource extends Resource
{
    /**
     * @return mixed[]
     *
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
            'created_by' => $clientService->getCreatedBy()?->getFullName(),
            'updated_by' => $clientService->getUpdatedBy()?->getFullName(),
        ];
    }
}
