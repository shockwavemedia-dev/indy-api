<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketEmails;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\TicketEmailMarkAsReadRequest;
use App\Http\Resources\API\Tickets\TicketEmailResource;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

final class TicketEmailMarkAsReadController extends AbstractAPIController
{
    private TicketEmailRepositoryInterface $ticketEmailRepository;

    public function __construct(TicketEmailRepositoryInterface $ticketEmailRepository)
    {
        $this->ticketEmailRepository = $ticketEmailRepository;
    }

    public function __invoke(TicketEmailMarkAsReadRequest $request, int $id): JsonResource
    {
        /** @var TicketEmail $ticketEmail */
        $ticketEmail = $this->ticketEmailRepository->find($id);

        if ($ticketEmail === null) {
            return $this->respondNotFound([
                'message' => 'Ticket Email not found.',
            ]);
        }

        try {
            /** @var User $user */
            $user = $this->getUser();

            $ticketEmail = $this->ticketEmailRepository->markAsRead($ticketEmail, $user, $request->getIsRead());

            return new TicketEmailResource($ticketEmail);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
