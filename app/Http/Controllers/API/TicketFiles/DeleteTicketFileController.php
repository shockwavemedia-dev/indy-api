<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\TicketRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteTicketFileController extends AbstractAPIController
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    private FileRepositoryInterface $fileRepository;

    private TicketRepository $ticketRepository;

    public function __construct(
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        FileRepositoryInterface $fileRepository,
        TicketRepository $ticketRepository
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->fileRepository = $fileRepository;
        $this->ticketRepository = $ticketRepository;
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

            $countNewTicketFile = $this->clientTicketFileRepository->countNewTicketFile($clientTicketFile);

            if($countNewTicketFile === 0){
                $this->ticketRepository->updateIsApprovalRequired($clientTicketFile->getTicket(), false);
            }

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
