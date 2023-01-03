<?php

declare(strict_types=1);

namespace App\Services\Folders;

use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderFactoryInterface;
use App\Services\Folders\Resources\CreateFolderResource;

final class FolderFactory implements FolderFactoryInterface
{
    private FolderRepositoryInterface $folderRepository;

    public function __construct(FolderRepositoryInterface $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    public function make(CreateFolderResource $resource): Folder
    {
        /** @var Folder $folder */
        $folder = $this->folderRepository->create([
            'client_id' => $resource->getClient()->getId(),
            'parent_folder_id' => $resource->getParentFolder()?->getId(),
            'name' => $resource->getName(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $folder;
    }
}
