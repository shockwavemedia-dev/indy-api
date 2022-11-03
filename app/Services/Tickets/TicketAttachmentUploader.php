<?php

declare(strict_types=1);

namespace App\Services\Tickets;

use App\Jobs\File\UploadTicketAttachmentJob;
use App\Services\Tickets\Interfaces\TicketAttachmentUploaderInterface;
use App\Services\Tickets\Resources\UploadTicketAttachmentResource;

/**
 * @deprecated
 */
final class TicketAttachmentUploader implements TicketAttachmentUploaderInterface
{
    public function upload(UploadTicketAttachmentResource $resource): void
    {
        // Needed to save the file temporary in app server before uploading directly to the Google cloud
        $resource->getFile()->storeAs(
            'temporary',
            $resource->getFilename()
        );

        UploadTicketAttachmentJob::dispatch(
            $resource->getTicketEvent()->getTicket()->getClientId(),
            $resource->getFilename(),
            $resource->getPath(),
        );
    }
}
