<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Files;

use App\Http\Controllers\API\AbstractAPIController;
use App\Jobs\File\RemoveFileJob;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteFileController extends AbstractAPIController
{
    public function __construct(private FileRepositoryInterface $fileRepository)
    {
    }

    public function __invoke(int $clientId, int $fileId): JsonResource
    {
        /** @var File $file */
        $file = $this->fileRepository->find($fileId);

        if ($file === null) {
            return $this->respondNotFound(['message' => 'File not found.']);
        }

        if ($file->getFolder()?->getClient()->getId() !== $clientId) {
            return $this->respondNoContent();
        }

        if ($file->getClientTicketFile() !== null) {
            return $this->respondNotFound(['message' => 'File not found.']);
        }

        RemoveFileJob::dispatch($file->getId(), $this->getUser()->getId());

        return $this->respondNoContent();
    }
}
