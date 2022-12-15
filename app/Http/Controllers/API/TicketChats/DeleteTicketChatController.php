<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketChats;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\TicketChatRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteTicketChatController extends AbstractAPIController
{
    public function __construct(private TicketChatRepositoryInterface $ticketChatRepository)
    {
    }

    public function __invoke(int $id): JsonResource
    {
        $ticketChat = $this->ticketChatRepository->find($id);

        if ($ticketChat === null) {
            $this->respondNoContent();
        }

        $ticketChat->delete();

        return $this->respondNoContent();
    }
}
