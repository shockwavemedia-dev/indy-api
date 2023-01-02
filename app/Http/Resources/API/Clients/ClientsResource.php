<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Clients;

use App\Http\Resources\Resource;

final class ClientsResource extends Resource
{
    protected function getResponse(): array
    {
        $clients = [];

        foreach ($this->resource as $client) {
            $clients['data'][] = new ClientResource($client);
        }

        $clients['page'] = $this->paginationResource($this->resource);

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $clients;
    }
}
