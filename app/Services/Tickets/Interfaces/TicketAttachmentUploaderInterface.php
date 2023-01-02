<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces;

use App\Services\Tickets\Resources\UploadTicketAttachmentResource;

/**
 * @deprecated
 */
interface TicketAttachmentUploaderInterface
{
    public function upload(UploadTicketAttachmentResource $resource): void;
}
