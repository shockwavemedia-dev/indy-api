<?php

declare(strict_types=1);

namespace App\Services\InboundEmails\Processors;

use App\Models\Tickets\Ticket;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\InboundEmails\Interfaces\EmailAttachmentProcessorInterface;
use App\Services\InboundEmails\Interfaces\EmailAttachmentUploadProcessorInterface;

final class EmailAttachmentProcessor implements EmailAttachmentProcessorInterface
{
    public function __construct(
        private BucketFactoryInterface $bucketFactory,
        private EmailAttachmentUploadProcessorInterface $emailAttachmentUploadProcessor,
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function process(Ticket $ticket, array $attachments): void
    {
        $bucket = $this->bucketFactory->make($ticket->getClient()->getClientCode());

        foreach ($attachments as $attachment) {
            $this->emailAttachmentUploadProcessor->upload(
                $ticket,
                $attachment,
                $bucket
            );
        }
    }
}
