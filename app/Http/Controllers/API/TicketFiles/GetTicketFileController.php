<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class GetTicketFileController extends AbstractAPIController
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    public function __construct(
        ClientTicketFileRepositoryInterface $clientTicketFileRepository
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            /** @var ClientTicketFile $clientTicketFile */
            $clientTicketFile = $this->clientTicketFileRepository->find($id);

            if ($clientTicketFile === null) {
                return $this->respondNotFound(
                    ['message' => 'File not found']
                );
            }

            return new TicketFileResource($clientTicketFile);
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
