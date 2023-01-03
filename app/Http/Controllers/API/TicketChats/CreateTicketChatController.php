<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketChats;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketChats\CreateTicketChatRequest;
use App\Http\Resources\API\TicketChats\TicketChatResource;
use App\Jobs\NotificationsList\NotificationFactoryJob;
use App\Jobs\SendSlackNotificationJob;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\TicketChats\Interfaces\TicketChatFactoryInterface;
use App\Services\TicketChats\Resources\CreateTicketChatResource;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

final class CreateTicketChatController extends AbstractAPIController
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private TicketChatFactoryInterface $ticketChatFactory,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws Exception
     */
    public function __invoke(CreateTicketChatRequest $request, int $id): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound(['message' => 'Ticket not found']);
        }

        $ticketChat = $this->ticketChatFactory->make(new CreateTicketChatResource([
            'user' => $this->getUser(),
            'ticket' => $ticket,
            'message' => $request->getMessage(),
        ]));

        if (count($request->getTaggedUsers()) > 0) {
            $users = $this->userRepository->findByIds($request->getTaggedUsers());

            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new Exception('Url for client is empty');
            }

            $url = sprintf('%s/ticket/%s', $url, $ticket->getId());

            /** @var User $user */
            foreach ($users as $user) {
                $message = \sprintf(
                    'Hi %s, You have been mentioned by %s in ticket %s.',
                    $user->getFirstName(),
                    $this->getUser()->getFirstName(),
                    $ticket->getId(),
                );

                $subject = sprintf('You have been mentioned in Ticket %s', $ticket->getId());

                $user->sendGenericNotificationWithEmailLog($ticketChat, $message, $url, $subject);

                $slackMessageWithLink = sprintf(
                    '%s You may check the link here %s',
                    $message,
                    $url,
                );

                SendSlackNotificationJob::dispatch($user->getId(), $slackMessageWithLink);

                NotificationFactoryJob::dispatch($ticketChat, $url, $message, $user->getId());
            }
        }

        return new TicketChatResource($ticketChat);
    }
}
