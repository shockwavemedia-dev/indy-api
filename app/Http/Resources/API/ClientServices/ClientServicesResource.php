<?php

declare(strict_types=1);

namespace App\Http\Resources\API\ClientServices;

use App\Enum\ServicesEnum;
use App\Http\Resources\Resource;
use App\Models\ClientService;

final class ClientServicesResource extends Resource
{
    public function __construct($resource, public bool $isAdmin = false)
    {
        parent::__construct($resource);
    }

    protected function getResponse(): array
    {
        $clientServices = [];

        $orderBy = [
            ServicesEnum::GRAPHIC_DESIGN,
            ServicesEnum::ANIMATION,
            ServicesEnum::WEBSITE,
            ServicesEnum::SOCIAL_MEDIA,
            ServicesEnum::SOCIAL_MEDIA_SPEND,
            ServicesEnum::IN_HOUSE_SCREENS,
            ServicesEnum::EDM,
            ServicesEnum::PRINT,
        ];

        foreach ($orderBy as $serviceOrder) {
            /** @var ClientService $clientService */
            foreach ($this->resource as $clientService) {
                $service = $clientService->getService();

                iF ($serviceOrder !== $service->getName()) {
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
