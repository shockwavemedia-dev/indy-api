<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles;

use App\Enum\TicketFileStatusEnum;
use App\Models\File;
use App\Models\TicketFileVersion;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileUploadInterface;
use App\Services\ClientTicketFiles\Interfaces\TicketFileFactoryInterface;
use App\Services\ClientTicketFiles\Resources\CreateClientTicketFileResource;
use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use App\Services\FileManager\Interfaces\FileUploadDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use Illuminate\Http\UploadedFile;

final class ProcessTicketFileUpload implements ProcessTicketFileUploadInterface
{
    private FileUploaderInterface $fileUploader;

    private TicketFileFactoryInterface $ticketFileFactory;

    public function __construct(
        FileManagerConfigResolverInterface $fileManagerConfigResolver,
        FileUploadDriverFactoryInterface $fileDriverFactory,
        FileUploaderInterface $fileUploader,
        TicketFileFactoryInterface $ticketFileFactory
    ) {
        $this->fileManagerConfigResolver = $fileManagerConfigResolver;
        $this->fileDriverFactory = $fileDriverFactory;
        $this->fileUploader = $fileUploader;
        $this->ticketFileFactory = $ticketFileFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function process(
        File $file,
        User $user,
        Ticket $ticket,
        UploadedFile $uploadedFile
    ): ClientTicketFile {
        //@TODO remove file and transition of version files
        $ticketFile = $this->ticketFileFactory->make(new CreateClientTicketFileResource([
            'file' => $file,
            'ticket' => $ticket,
            'statusEnum' => new TicketFileStatusEnum(TicketFileStatusEnum::NEW),
            'description' => null,
            'assignedStaff' => $user->getUserType(),
        ]));

        TicketFileVersion::create([
            'version' => 1,
            'file_id' => $file->getId(),
            'ticket_file_id' => $ticketFile->getId(),
            'status' => new TicketFileStatusEnum(TicketFileStatusEnum::NEW),
        ]);

        $this->fileUploader->upload(new UploadFileResource([
            'fileObject' => $uploadedFile,
            'fileModel' => $file,
        ]));

        return $ticketFile;
    }
}
