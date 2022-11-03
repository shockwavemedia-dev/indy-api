<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketEmails;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\TicketEmailStatusEnum;
use App\Enum\UserTypeEnum;
use App\Events\Tickets\TicketEmailsEvent;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Tickets\CreateTicketEmailRequest;
use App\Http\Resources\API\Tickets\TicketEmailResource;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\TicketEmails\Interfaces\TicketEmailFactoryInterface;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderFactoryInterface;
use App\Services\TicketEmails\Resources\CreateTicketEmailResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateTicketEmailController extends AbstractAPIController
{
    private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory;

    private TicketEmailFactoryInterface $ticketEmailFactory;

    private TicketRepositoryInterface $ticketRepository;

    private TicketEmailSenderFactoryInterface $ticketEmailSenderFactory;

    public function __construct(
        ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        TicketEmailSenderFactoryInterface $ticketEmailSenderFactory,
        TicketEmailFactoryInterface $ticketEmailFactory,
        TicketRepositoryInterface $ticketRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->clientNotificationResolverFactory = $clientNotificationResolverFactory;
        $this->ticketEmailSenderFactory = $ticketEmailSenderFactory;
        $this->ticketEmailFactory = $ticketEmailFactory;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(CreateTicketEmailRequest $request, int $id): JsonResource
    {
        try {
            /** @var Ticket $ticket */
            $ticket = $this->ticketRepository->find($id);

            if ($ticket === null) {
                return $this->respondNotFound([
                    'message' => 'Ticket not found.',
                ]);
            }

            /** @var User $user */
            $user = $this->getUser();

            $userType = $user->getUserType()->getType();

            $ticketEmail = $this->ticketEmailFactory->make(new CreateTicketEmailResource([
                'clientId' => $ticket->getClientId(),
                'ticketId' => $ticket->getId(),
                'senderBy' => $user->getId(),
                'title' => $request->getTitle(),
                'cc' => $request->getCc(),
                'message' => $request->getMessage(),
                'senderType' => $userType->getValue(),
                'status' => new TicketEmailStatusEnum(TicketEmailStatusEnum::PENDING),    // Default status is pending
            ]));

            $sender = $this->ticketEmailSenderFactory->make($userType);

            $sender->send($ticketEmail);

            TicketEmailsEvent::dispatch($ticket->getTicketEmails(), $ticket);

            $clientNotificationResolver = $this->clientNotificationResolverFactory
                ->make(new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_EMAILS));

            $clientNotificationResolver->resolve($ticketEmail);

            return new TicketEmailResource($ticketEmail);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
