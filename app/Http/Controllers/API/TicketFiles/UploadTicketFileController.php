<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketFiles\UploadFileRequest;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\File;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileUploadInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class UploadTicketFileController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private TicketRepository $ticketRepository;

    private ProcessTicketFileUploadInterface $processTicketFileUpload;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        FolderRepositoryInterface $folderRepository,
        ProcessTicketFileUploadInterface $processTicketFileUpload,
        TicketRepository $ticketRepository
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->folderRepository = $folderRepository;
        $this->processTicketFileUpload = $processTicketFileUpload;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id, UploadFileRequest $request): JsonResource
    {
        try{
            /** @var \App\Models\Tickets\Ticket $ticket */
            $ticket = $this->ticketRepository->find($id);

            if ($ticket === null) {
                return $this->respondNotFound([
                    'message' => 'Ticket not found.',
                ]);
            }

            /** @var \App\Models\User $user */
            $user = $this->getUser();

            $client = $ticket->getClient();

            $bucket = $this->bucketFactory->make($client->getClientCode());

            $folder = $this->folderRepository->find($request->getFolderId() ?? 0);

            $file = $this->fileFactory->make(new CreateFileResource([
                'bucket' => $bucket->name(),
                'folder' => $folder,
                'uploadedFile' => $request->getFile(),
                'disk' => $bucket->disk(),
                'uploadedBy' => $user,
                'fileExtension' => $request->getFile()->getClientOriginalExtension(),
                'filePath' => \sprintf('%s/%s',
                    $client->getClientCode(),
                    'tickets'
                ),
            ]));

            $ticketFile = $this->processTicketFileUpload->process(
                $file,
                $user,
                $ticket,
                $request->getFile(),
            );

            return new TicketFileResource($ticketFile);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
