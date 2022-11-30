<?php

namespace App\Services\InboundEmails\Processors;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Jobs\File\UploadEmailAttachmentJob;
use App\Models\File;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Bucket;
use App\Services\InboundEmails\Interfaces\EmailAttachmentUploadProcessorInterface;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;
use Illuminate\Support\Facades\Storage;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use ZBateson\MailMimeParser\Message\IMessagePart;

final class EmailAttachmentUploadProcessor implements EmailAttachmentUploadProcessorInterface
{
    public function __construct(
        private ErrorLogInterface $errorLog,
        private FileRepositoryInterface $fileRepository,
        private TicketEventAttachmentFactoryInterface $ticketEventAttachmentFactory
    ) {
    }

    /**
     * @throws UnknownProperties
     */
    public function upload(Ticket $ticket, IMessagePart $attachment, Bucket $bucket): void
    {
        try {
            $filename = \pathinfo($attachment->getFilename(), PATHINFO_FILENAME);

            $regex = '/[^a-zA-Z0-9._ -]/';

            $originalFileName = preg_replace($regex, '', $attachment->getFilename());

            $originalFileName = str_replace(' ', '', $originalFileName);

            $generatedFilename = \sprintf(
                '%s-%s',
                \sha1(\sprintf('%s%s', $filename, time())),
                $originalFileName
            );

            $filepath = \sprintf('%s/%s', storage_path('app'), $generatedFilename);

            // Save file locally
            $attachment->saveContent($filepath);

            /** @var File $file */
            $file = $this->fileRepository->create([
                'original_filename' => $attachment->getFilename(),
                'file_name' => $generatedFilename,
                'file_size' => '',
                'file_path' => \sprintf('attachments/%s', $ticket->getId()),
                'file_extension' => $attachment->getContentType(),
                'file_type' => $attachment->getContentType(),
                'folder_id' => null,
                'uploaded_by' => $ticket->getCreatedById(),
                'disk' => $bucket->disk(),
                'bucket' => $bucket->name(),
            ]);

            $this->ticketEventAttachmentFactory->make(new CreateTicketEventAttachmentResource([
                'file' => $file,
                'ticketEvent' => $ticket->getTicketEvent(),
            ]));

            $rawFile = Storage::disk('local')->get($generatedFilename);

            if ($rawFile === null) {
                $this->errorLog->log('Empty raw file, line 71');
            }

            UploadEmailAttachmentJob::dispatch(
                $file->getId(),
                base64_encode($rawFile)
            );
        } catch (\Exception $exception) {
            $this->errorLog->reportError($exception);
        }
    }
}
