<?php

declare(strict_types=1);

namespace App\Services\EventsService\Factories;

use App\Models\Event;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\EventsService\Interfaces\EventFolderFactoryInterface;
use App\Services\Folders\Interfaces\FolderFactoryInterface;
use App\Services\Folders\Resources\CreateFolderResource;

final class EventFolderFactory implements EventFolderFactoryInterface
{
    private FolderFactoryInterface $folderFactory;

    private FolderRepositoryInterface $folderRepository;

    public function __construct(
        FolderFactoryInterface $folderFactory,
        FolderRepositoryInterface $folderRepository
    ) {
        $this->folderFactory = $folderFactory;
        $this->folderRepository = $folderRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function make(Event $event): Folder
    {
        $parentFolder = $this->parentFolderResolver($event);

        $folder = $this->folderFactory->make(new CreateFolderResource([
            'client' => $event->getClient(),
            'createdBy' => $event->getCreatedBy(),
            'name' => $event->getShootTitle(),
            'parentFolder' => $parentFolder,
        ]));

        $event->folder()->associate($folder);
        $event->save();

        return $folder;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function parentFolderResolver(Event $event): Folder
    {
        $parentFolder = $this->folderRepository->findByClientAndName(
            $event->getClient(),
            $event->getServiceType()->getValue()
        );

        if ($parentFolder !== null) {
            return $parentFolder;
        }

        return $this->folderFactory->make(new CreateFolderResource([
            'client' => $event->getClient(),
            'createdBy' => $event->getCreatedBy(),
            'name' => $event->getServiceType()->getValue(),
        ]));
    }
}
