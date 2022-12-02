<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketFiles\TicketFileResource;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ApproveTicketFileController extends AbstractAPIController
{
    private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory;

    private ClientTicketFileRepositoryInterface $ticketFileRepository;

    private TicketActivityFactoryInterface $ticketActivityFactory;

    private TicketRepository $ticketRepository;

    public function __construct(
        BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        ClientTicketFileRepositoryInterface $ticketFileRepository,
        TicketActivityFactoryInterface $ticketActivityFactory,
        TicketRepository $ticketRepository
    ) {
        $this->backendUserNotificationResolverFactory = $backendUserNotificationResolverFactory;
        $this->ticketFileRepository = $ticketFileRepository;
        $this->ticketActivityFactory = $ticketActivityFactory;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            /** @var ClientTicketFile $ticketFile */
            $ticketFile = $this->ticketFileRepository->find($id);

            $notificationResolver = $this->backendUserNotificationResolverFactory->make(
                new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::FILE_APPROVED),
            );

            $notificationResolver->resolve($ticketFile);

            if ($ticketFile === null) {
                return $this->respondNotFound([
                    'message' => 'Ticket File not found.',
                ]);
            }

            if ($ticketFile->isApproved() === true) {
                return new TicketFileResource($ticketFile);
            }

            /** @var User $user */
            $user = $this->getUser();

            $ticketFile = $this->ticketFileRepository->approve($user, $ticketFile);

            $this->ticketActivityFactory->make(new CreateTicketActivityResource([
                'ticket' => $ticketFile->getTicket(),
                'user' => $user,
                'activity' => \sprintf('%s approved the file.', $user->getFirstName()),
            ]));

            $countNewTicketFile = $this->ticketFileRepository->countNewTicketFile($ticketFile);

            if($countNewTicketFile > 0){
                return new TicketFileResource($ticketFile);
            }

            $this->ticketRepository->updateIsApprovalRequired($ticketFile->getTicket(), false);

            return new TicketFileResource($ticketFile);
        } catch(Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
