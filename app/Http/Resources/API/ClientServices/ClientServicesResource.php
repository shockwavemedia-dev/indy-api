<?php

declare(strict_types=1);

namespace App\Http\Resources\API\ClientServices;

use App\Enum\ServicesEnum;
use App\Http\Resources\Resource;
use App\Models\ClientService;

final class ClientServicesResource extends Resource
{
    protected function getResponse(): array
    {
        $clientServices = [];

        $orderBy = [
            ServicesEnum::GRAPHIC_DESIGN,
            ServicesEnum::ANIMATION,
            ServicesEnum::WEBSITE,
            ServicesEnum::SOCIAL_MEDIA,
            ServicesEnum::EDM,
            ServicesEnum::PRINT,
        ];

        foreach ($orderBy as $serviceOrder) {
            /** @var ClientService $clientService */
            foreach ($this->resource as $clientService) {
                $service = $clientService->getService();

                if ($serviceOrder !== $service->getName()) {
                    continue;
                }

                $clientServices['data'][] = new ClientServiceResource($clientService);
            }
        }

        $clientServices['page'] = $this->paginationResource($this->resource);

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $clientServices;
    }
}
