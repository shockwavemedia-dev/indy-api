<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Jobs\File\RemoveFileJob;
use App\Jobs\TicketFiles\UpdateApprovalIsRequiredJob;
use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteTicketFileController extends AbstractAPIController
{
    public function __construct(
        private ClientTicketFileRepositoryInterface $clientTicketFileRepository,
    ) {
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            /** @var ClientTicketFile $clientTicketFile */
            $clientTicketFile = $this->clientTicketFileRepository->find($id);

            if ($clientTicketFile === null || $clientTicketFile->isApproved() === true) {
                return $this->respondNoContent();
            }

            $fileVersion = $clientTicketFile->getLatestFileVersion();

            // Delete the file in s3 and database soft delete
            RemoveFileJob::dispatch(
                $fileVersion->getFile()->getId(),
                $this->getUser()->getId()
            );

            // Delete the latest file version. Only latest version can be deleted for now.
            $fileVersion->delete();

            UpdateApprovalIsRequiredJob::dispatch($clientTicketFile->getId());

            return $this->respondNoContent();
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
