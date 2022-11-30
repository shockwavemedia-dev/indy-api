<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketNotes;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\ClientNotificationTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketNotes\CreateTicketNoteRequest;
use App\Http\Resources\API\TicketNotes\TicketNoteResource;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\TicketNotes\Interfaces\TicketNoteFactoryInterface;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateTicketNoteController extends AbstractAPIController
{
    private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory;

    private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory;

    private TicketRepositoryInterface $ticketRepository;

    private TicketNoteFactoryInterface $ticketNoteFactory;

    public function __construct(
        BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        TicketRepositoryInterface $ticketRepository,
        TicketNoteFactoryInterface $ticketNoteFactory
    ) {
        $this->backendUserNotificationResolverFactory = $backendUserNotificationResolverFactory;
        $this->clientNotificationResolverFactory = $clientNotificationResolverFactory;
        $this->ticketRepository = $ticketRepository;
        $this->ticketNoteFactory = $ticketNoteFactory;
    }

    public function __invoke(CreateTicketNoteRequest $request, int $id): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        try {
            $ticketNote = $this->ticketNoteFactory->make(new CreateTicketNoteResource([
                'createdBy' => $this->getUser(),
                'ticket' => $ticket,
                'note' => $request->getNote(),
            ]));

            $backendUserNotificationResolver = $this->backendUserNotificationResolverFactory->make(
                new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::TICKET_NOTES)
            );

            $backendUserNotificationResolver->resolve($ticketNote);

            $clientNotificationResolver = $this->clientNotificationResolverFactory->make(
                new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_NOTES)
            );

            $clientNotificationResolver->resolve($ticketNote);

            $this->ticketRepository->increaseUserNotesExceptSender($ticket, $this->getUser());

            return new TicketNoteResource($ticketNote);
            // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
