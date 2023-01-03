<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketNotes;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\ClientNotificationTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketNotes\CreateTicketNoteRequest;
use App\Http\Resources\API\TicketNotes\TicketNoteResource;
use App\Models\Tickets\Ticket;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\TicketNotes\Interfaces\NoteAttachmentFactoryInterface;
use App\Services\TicketNotes\Interfaces\TicketNoteFactoryInterface;
use App\Services\TicketNotes\Resources\CreateNoteAttachmentResource;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateTicketNoteController extends AbstractAPIController
{
    public function __construct(
        private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        private BucketFactoryInterface $bucketFactory,
        private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        private FileFactoryInterface $fileFactory,
        private FileUploaderInterface $fileUploader,
        private TicketRepositoryInterface $ticketRepository,
        private TicketNoteFactoryInterface $ticketNoteFactory,
        private NoteAttachmentFactoryInterface $noteAttachmentFactory
    ) {
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

            if ($this->getUser()->getUserType() instanceof ClientUser === true) {
                $backendUserNotificationResolver = $this->backendUserNotificationResolverFactory->make(
                    new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::TICKET_NOTES)
                );

                $backendUserNotificationResolver->resolve($ticketNote);
            }

            $clientNotificationResolver = $this->clientNotificationResolverFactory->make(
                new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_NOTES)
            );

            $clientNotificationResolver->resolve($ticketNote);

            $this->ticketRepository->increaseUserNotesExceptSender($ticket, $this->getUser());

            $files = $request->getAttachments();

            if (\count($files) === 0) {
                return new TicketNoteResource($ticketNote);
            }

            $client = $ticketNote->getTicket()->getClient();

            $bucket = $this->bucketFactory->make($client->getClientCode());

            foreach ($files as $file) {
                $fileModel = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $file,
                    'disk' => $bucket->disk(), // Default to google cloud server driver
                    'filePath' => 'ticket-notes',
                    'uploadedBy' => $this->getUser(),
                    'bucket' => $bucket->name(),
                ]));

                $this->noteAttachmentFactory->make(new CreateNoteAttachmentResource([
                    'ticketNote' => $ticketNote,
                    'file' => $fileModel,
                    'createdBy' => $this->getUser(),
                ]));

                $this->fileUploader->upload(new UploadFileResource([
                    'fileObject' => $file,
                    'fileModel' => $fileModel,
                ]));
            }

            return new TicketNoteResource($ticketNote);
            // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
