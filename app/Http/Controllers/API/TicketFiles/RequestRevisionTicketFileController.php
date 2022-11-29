<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\ClientNotificationTypeEnum;
use App\Enum\TicketFileStatusEnum;
use App\Enum\TicketStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\TicketNotes\Interfaces\TicketNoteFactoryInterface;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class RequestRevisionTicketFileController extends AbstractAPIController
{
    public function __construct(
        private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        private ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        private TicketNoteFactoryInterface $ticketNoteFactory,
        private TicketRepositoryInterface $ticketRepository
    ) {
    }

    public function __invoke(int $id, Request $request): JsonResource
    {
        /** @var ClientTicketFile $clientTicketFile */
        $clientTicketFile = $this->clientTicketFileRepository->find($id);

        if ($clientTicketFile === null) {
            return $this->respondNotFound(['message' => 'Ticket File not found.']);
        }

        $fileVersion = $clientTicketFile->getLatestFileVersion();

        try {
            if ($fileVersion === null) {
                return new TicketFileResource($clientTicketFile);
            }

            $fileVersion->setAttribute('status', TicketFileStatusEnum::DECLINED);
            $fileVersion->save();

            $clientTicketFile->setAttribute('status', TicketFileStatusEnum::REQUEST_REVISION);
            $clientTicketFile->save();
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }

        try {
            $ticketNote = $this->ticketNoteFactory->make(new CreateTicketNoteResource([
                'ticketFileVersion' => $fileVersion,
                'createdBy' => $this->getUser(),
                'ticket' => $clientTicketFile->getTicket(),
                'note' => $request->get('message'),
            ]));

            $backendUserNotificationResolver = $this->backendUserNotificationResolverFactory->make(
                new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::TICKET_NOTES)
            );

            $backendUserNotificationResolver->resolve($ticketNote);

            $clientNotificationResolver = $this->clientNotificationResolverFactory->make(
                new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_NOTES)
            );

            $clientNotificationResolver->resolve($ticketNote);

            $this->ticketRepository->increaseUserNotesExceptSender($clientTicketFile->getTicket(), $this->getUser());

            // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            return new TicketFileResource($clientTicketFile);
        }
        // @codeCoverageIgnoreEnd
    }
}
