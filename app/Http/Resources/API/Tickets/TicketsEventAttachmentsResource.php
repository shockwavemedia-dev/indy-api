<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Http\Resources\Resource;

final class TicketsEventAttachmentsResource extends Resource
{
    protected function getResponse(): array
    {
        $attachments = [];

        foreach ($this->resource as $eventAttachment) {
            $attachments[] = new TicketEventAttachmentResource($eventAttachment);
        }

        return $attachments;
    }
}
