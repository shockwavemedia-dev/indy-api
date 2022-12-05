<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Enum\TicketFileStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketFiles\UploadFileRequest;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\TicketFileVersion;
use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class RevisionTicketFileUploadController extends AbstractAPIController
{
    public function __construct(
        private ClientTicketFileRepositoryInterface $ticketFileRepository,
        private FileFactoryInterface $fileFactory,
        private  FileUploaderInterface $fileUploader,
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function __invoke(int $id, UploadFileRequest $request): JsonResource
    {
        /** @var ClientTicketFile $ticketFile */
        $ticketFile = $this->ticketFileRepository->find($id);

        if ($ticketFile === null) {
            return $this->respondNotFound(['message' => 'Ticket File not found.']);
        }

        $latestFile = $ticketFile->getLatestFileVersion()->getFile();

        $file = $request->getFile();

        $fileModel = $this->fileFactory->make(new CreateFileResource([
            'bucket' => $latestFile->getBucket(),
            'folder' => $latestFile->getFolder(),
            'uploadedFile' => $file,
            'disk' => $latestFile->getDisk(),
            'uploadedBy' => $this->getUser(),
            'fileExtension' => $file->getClientOriginalExtension(),
            'filePath' => $latestFile->getFilePath(),
        ]));

        TicketFileVersion::create([
            'version' => $ticketFile->getLatestFileVersion()->getVersion() + 1,
            'file_id' => $fileModel->getId(),
            'ticket_file_id' => $ticketFile->getId(),
            'status' => new TicketFileStatusEnum(TicketFileStatusEnum::NEW),
        ]);

        $ticketFile->setStatus(new TicketFileStatusEnum(TicketFileStatusEnum::NEW));

        $this->fileUploader->upload(new UploadFileResource([
            'fileObject' => $file,
            'fileModel' => $fileModel,
        ]));

        return new TicketFileResource($ticketFile);
    }
}
