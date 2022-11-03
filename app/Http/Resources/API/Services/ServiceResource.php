<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Services;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Service;

final class ServiceResource extends Resource
{
    /**
     * @return mixed[]
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Service) === false) {
            throw new InvalidResourceTypeException(
                Service::class
            );
        }

        /** @var \App\Models\Service $service */
        $service = $this->resource;

        return [
            'id' => $service->getId(),
            'name' => $service->getName(),
            'extras' => $service->getExtras()
        ];
    }
}
