<?php

declare(strict_types=1);

namespace App\Services\EventsService\Resolvers;

use App\Models\Event;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\EventsService\Interfaces\EventFileFolderUpdateResolverInterface;

final class EventFileFolderUpdateResolver implements EventFileFolderUpdateResolverInterface
{
    private FolderRepositoryInterface $folderRepository;

    public function __construct(FolderRepositoryInterface $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    public function resolve(Event $event): void
    {
        $this->folderRepository->updateFolder(
            $event->getFolder(),
            $event->getUpdatedBy(),
            $event->getShootTitle()
        );
    }
}
