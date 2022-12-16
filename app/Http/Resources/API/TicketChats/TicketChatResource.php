<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketChats;

use App\Http\Resources\Resource;

final class TicketChatResource extends Resource
{
    protected function getResponse(): array
    {
        return [
            'id' => $this->resource->getId(),
            'message' => $this->resource->getMessage(),
            'created_at' => $this->resource->getCreatedAtAsString(),
            'created_by' => $this->resource->getCreatedBy()->getFullName(),
            'profile_url' => $this->resource->getCreatedBy()->getProfileFile()?->getUrl(),
        ];
    }
}
