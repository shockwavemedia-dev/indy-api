<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enum\EmailStatusEnum;
use App\Enum\NotificationStatusEnum;
use App\Enum\ServicesEnum;
use App\Enum\TicketFileStatusEnum;
use App\Jobs\SocialMedia\SocialMediaSlackNotificationJob;
use App\Jobs\Tickets\TicketFileSlackNotificationJob;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\TicketService;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class ClientTicketFileObserver
{
    private DepartmentRepositoryInterface $departmentRepository;

    private EmailLogFactoryInterface $emailLogFactory;

    private NotificationFactoryInterface $notificationFactory;

    private NotificationUserFactoryInterface $notificationUserFactory;

    private TicketActivityFactoryInterface $activityFactory;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        EmailLogFactoryInterface $emailLogFactory,
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory,
        TicketActivityFactoryInterface $activityFactory
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->emailLogFactory = $emailLogFactory;
        $this->notificationFactory = $notificationFactory;
        $this->notificationUserFactory = $notificationUserFactory;
        $this->activityFactory = $activityFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(ClientTicketFile $clientTicketFile): void
    {
//        Disabled for now, only designated social media should be notified
//
//        /** @var TicketService $ticketService */
//        foreach ($clientTicketFile->getTicket()->getTicketServices() as $ticketService) {
//            if ($ticketService->getService()->getName() === ServicesEnum::SOCIAL_MEDIA) {
//                $this->notifySocialMediaFileUploaded($clientTicketFile);
//            }
//        }
        $this->ticketFileActivity($clientTicketFile);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function updated(ClientTicketFile $clientTicketFile): void
    {
        $ticket = $clientTicketFile->getTicket();

        if ($clientTicketFile->isApproved() === true) {
            $this->notifyUploader($clientTicketFile, 'approved');
        }

        if ($clientTicketFile->getStatus()->getValue() === TicketFileStatusEnum::REQUEST_REVISION) {
            $this->notifyUploader($clientTicketFile, 'declined');
        }

        /** @var TicketService $ticketService */
        foreach ($ticket->getTicketServices() as $ticketService) {
            if ($ticketService->getService()->getName() === ServicesEnum::SOCIAL_MEDIA) {
                if ($clientTicketFile->isApproved() === true) {
                    $this->notifySocialMediaFileApproved($clientTicketFile);
                    break;
                }
            }
        }
    }

    /**
     * @removed
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function notifySocialMediaFileUploaded(ClientTicketFile $clientTicketFile): void
    {
        $department = $this->departmentRepository->findByName(ServicesEnum::SOCIAL_MEDIA);

        /** @var AdminUser $adminUser */
        foreach ($department->getAdminUsers() as $adminUser) {
            $adminUser->getUser()->notifySocialMediaForFileUploaded(
                $clientTicketFile,
                $this->emailLogFactory->make(new CreateEmailLogResource([
                    'emailType' => $clientTicketFile,
                    'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                    'to' => $adminUser->getUser()->getEmail(),
                    'message' => 'Ticket File Uploaded Email', // Static message, real email is in json format
                ])),
            );

            SocialMediaSlackNotificationJob::dispatch(
                $adminUser->getUser(),
                \sprintf(
                    'File was uploaded in Ticket# %s.',
                    $clientTicketFile->getTicket()->getTicketCode()
                ),
                $clientTicketFile->getTicketId()
            );

            $this->saveNotification(
                $clientTicketFile,
                $adminUser->getUser(),
                \sprintf(
                    'File was uploaded in Ticket# %s.',
                    $clientTicketFile->getTicket()->getTicketCode()
                ),
            );
        }
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     *
     * @description notify only designated user for the client
     */
    private function notifySocialMediaFileApproved(ClientTicketFile $clientTicketFile): void
    {
        $adminUser = $clientTicketFile->getClient()->getDesignatedSocialMediaManager();

        if ($adminUser === null) {
            return;
        }

        $adminUser->getUser()->notifySocialMediaForFileApproved(
            $clientTicketFile,
            $this->emailLogFactory->make(new CreateEmailLogResource([
                'emailType' => $clientTicketFile,
                'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                'to' => $adminUser->getUser()->getEmail(),
                'message' => 'Ticket File Approved Email', // Static message, real email is in json format
            ])),
        );

        SocialMediaSlackNotificationJob::dispatch(
            $adminUser->getUser(),
            \sprintf(
                'Ticket# %s file has been approved.',
                $clientTicketFile->getTicket()->getTicketCode()
            ),
            $clientTicketFile->getTicketId()
        );

        $this->saveNotification(
            $clientTicketFile,
            $adminUser->getUser(),
            \sprintf(
                'Ticket# %s file has been approved.',
                $clientTicketFile->getTicket()->getTicketCode()
            ),
        );
//        $department = $this->departmentRepository->findByName(ServicesEnum::SOCIAL_MEDIA);

//        /** @var AdminUser $adminUser */
//        foreach ($department->getAdminUsers() as $adminUser) {
//
//        }
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function saveNotification(
        ClientTicketFile $clientTicketFile,
        User $user,
        string $title
    ): void {
        $notificationResource = new CreateNotificationResource([
            'morphable' => $clientTicketFile,
            'link' => \sprintf('ticket/%s', $clientTicketFile->getTicketId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => $title,
        ]);

        $notification = $this->notificationFactory->make($notificationResource);

        $this->notificationUserFactory->make(new CreateNotificationUserResource([
            'notification' => $notification,
            'user' => $user,
        ]));
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function notifyUploader(ClientTicketFile $clientTicketFile, $status): void
    {
        $uploader = $clientTicketFile->getAdminUser()->getUser();

        $uploader->notifyTicketFileUploader(
            $clientTicketFile,
            $this->emailLogFactory->make(new CreateEmailLogResource([
                'emailType' => $clientTicketFile,
                'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                'to' => $uploader->getEmail(),
                'message' => 'Ticket File Uploaded Email', // Static message, real email is in json format
            ])),
            $status
        );

        TicketFileSlackNotificationJob::dispatch(
            $uploader,
            \sprintf(
                'File is %s in Ticket# %s.',
                $clientTicketFile->getTicket()->getTicketCode(),
                $status
            ),
            $clientTicketFile->getTicketId()
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function ticketFileActivity(ClientTicketFile $clientTicketFile): void
    {
        $uploader = $clientTicketFile->getAdminUser()->getUser();

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $clientTicketFile->getTicket(),
            'user' => $uploader,
            'activity' => \sprintf(
                '%s uploaded ID #: %s for approval',
                $uploader->getFirstName(),
                $clientTicketFile->getId()
            ),
        ]));
    }
}
