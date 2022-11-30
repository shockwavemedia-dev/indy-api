<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketEventRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;
use App\Services\Tickets\Resources\CreateTicketResource;

final class TicketEventFactory extends AbstractTicketFactory implements TicketTypeResolverInterface
{
    private FileFactoryInterface $fileFactory;

    private FileUploaderInterface $fileUploader;

    private TicketEventAttachmentFactoryInterface $ticketEventAttachmentFactory;

    private TicketEventRepositoryInterface $ticketEventRepository;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler,
        FileFactoryInterface $fileFactory,
        FileUploaderInterface $fileUploader,
        TicketEventRepositoryInterface $ticketEventRepository,
        TicketEventAttachmentFactoryInterface $ticketEventAttachmentFactory,
        TicketRepositoryInterface $ticketRepository,
        TicketServicesFactoryInterface $ticketServiceFactory,
        MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        MarketingPlannerFactoryInterface $marketingPlannerFactory,
    ) {
        $this->fileFactory = $fileFactory;
        $this->fileUploader = $fileUploader;
        $this->ticketEventAttachmentFactory = $ticketEventAttachmentFactory;
        $this->ticketEventRepository = $ticketEventRepository;

        parent::__construct(
            $bucketFactory,
            $departmentTicketNotificationHandler,
            $attachmentProcessor,
            $marketingPlannerFactory,
            $ticketRepository,
            $ticketServiceFactory
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function create(CreateTicketResource $resource): Ticket
    {
        $ticket = $this->make($resource);

        $ticketEvent = $this->ticketEventRepository->create([
            'ticket_id' => $ticket->getId(),
        ]);

        foreach ($resource->getAttachments() ?? [] as $attachment) {
            $file = $this->fileFactory->make(new CreateFileResource([
                'uploadedFile' => $attachment,
                'bucket' => $this->bucket->name(),
                'disk' => $this->bucket->disk(),
                'filePath' => \sprintf('attachments/%s', $ticket->getId()),
                'uploadedBy' => $resource->getCreatedBy(),
            ]));

            $this->ticketEventAttachmentFactory->make(new CreateTicketEventAttachmentResource([
                'file' => $file,
                'ticketEvent' => $ticketEvent,
            ]));

            $this->fileUploader->upload(new UploadFileResource([
                'fileModel' => $file,
                'fileObject' => $attachment,
            ]));
        }

        return $ticket;
    }

    public function supports(TicketTypeEnum $type): bool
    {
        return $type->getValue() === TicketTypeEnum::PROJECT;
    }
}
