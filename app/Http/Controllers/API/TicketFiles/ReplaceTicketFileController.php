<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketFiles\UploadFileRequest;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileReplaceInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ReplaceTicketFileController extends AbstractAPIController
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    private ProcessTicketFileReplaceInterface $processTicketFileReplace;

    public function __construct(
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        ProcessTicketFileReplaceInterface $processTicketFileReplace
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->processTicketFileReplace = $processTicketFileReplace;
    }

    public function __invoke(int $id, UploadFileRequest $request): JsonResource
    {
        try{
            /** @var ClientTicketFile $clientTicketFile */
            $clientTicketFile = $this->clientTicketFileRepository->find($id);

            if ($clientTicketFile === null) {
                return $this->respondNotFound([
                    'message' => 'Ticket File not found',
                ]);
            }

            /** @var User $user */
            $user = $this->getUser();

            $ticketFile = $this->processTicketFileReplace->replace(
                $user,
                $clientTicketFile,
                $request->getFile(),
                $request->getFilePath(),
            );

            return new TicketFileResource($ticketFile);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
