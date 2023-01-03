<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketAssignee;

use App\Http\Resources\Resource;

final class TicketAssigneesResource extends Resource
{
    protected function getResponse(): array
    {
        $adminUsers = [];

        foreach ($this->resource as $adminUser) {
            $adminUsers['data'][] = new TicketAssigneeResource($adminUser);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $adminUsers['page'] = $this->paginationResource($this->resource);

        return $adminUsers;
    }
}
