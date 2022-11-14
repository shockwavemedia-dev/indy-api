<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteTicketFileController extends AbstractAPIController
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    private FileRepositoryInterface $fileRepository;

    public function __construct (
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        FileRepositoryInterface $fileRepository
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->fileRepository = $fileRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            /** @var ClientTicketFile $clientTicketFile */
            $clientTicketFile = $this->clientTicketFileRepository->find($id);

            if ($clientTicketFile === null || $clientTicketFile->isApproved() === true) {
                return $this->respondNoContent();
            }

            $this->clientTicketFileRepository->deleteTicketFile($clientTicketFile);

            if ($clientTicketFile->file !== null) {
                /** @var User $user */
                $user = $this->getUser();
                $this->fileRepository->deleteFile($clientTicketFile->file, $user);
            }
            return $this->respondNoContent();
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
