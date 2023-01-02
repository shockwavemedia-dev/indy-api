<?php

namespace App\Services\InboundEmails\Interfaces;

use App\Models\Tickets\Ticket;
use App\Services\FileManager\Bucket;
use ZBateson\MailMimeParser\Message\IMessagePart;

interface EmailAttachmentUploadProcessorInterface
{
    public function upload(Ticket $ticket, IMessagePart $attachment, Bucket $bucket): void;
}
