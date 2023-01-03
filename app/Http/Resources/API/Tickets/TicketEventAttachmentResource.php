<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\TicketEventAttachment;

final class TicketEventAttachmentResource extends Resource
{
    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof TicketEventAttachment) === false) {
            throw new InvalidResourceTypeException(TicketEventAttachment::class);
        }

        return [
            'id' => $this->resource->getId(),
            'file_type' => $this->resource->getFile()->getFileType(),
            'url' => $this->resource->getFile()->getUrl(),
        ];
    }
}
