<?php

declare(strict_types=1);

namespace App\Services\Folders\Resolvers;

use App\Models\Client;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderSortResolverInterface;
use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use Illuminate\Database\Eloquent\Collection;

final class FolderSortResolver implements FolderSortResolverInterface
{
    private FolderRepositoryInterface $folderRepository;

    private SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver;

    public function __construct(
        FolderRepositoryInterface $folderRepository,
        SortByYearAndMonthResolverInterface $sortByYearAndMonthResolver
    ) {
        $this->folderRepository = $folderRepository;
        $this->sortByYearAndMonthResolver = $sortByYearAndMonthResolver;
    }

    public function resolve(Client $client): array
    {
        $parentFolders = $this->folderRepository->findParentFoldersByClient($client);

        return $this->sortParentFolders($client, $parentFolders);
    }

    private function sortParentFolders(Client $client, Collection $folders): array
    {
        $result = [];

        /** @var Folder $folder */
        foreach ($folders as $folder) {
            if ($folder->getParentFolder() === null) {
                $result[$folder->getName()]['id'] = $folder->getId();
                $result[$folder->getName()]['name'] = $folder->getName();
                $result[$folder->getName()]['files'] = $this->traverseFiles($client, $folder->getFiles());
                $result[$folder->getName()]['folders'][] = $this->sortSubFolders($client, $folder->getChildFolders());
            }
        }

        return $result;
    }

    private function sortSubFolders(Client $client, Collection $childFolders): array
    {
        $subFolders = [];

        /** @var Folder $childFolder */
        foreach ($childFolders as $childFolder) {
            $subFolders[$childFolder->getName()]['id'] = $childFolder->getId();
            $subFolders[$childFolder->getName()]['name'] = $childFolder->getName();
            $subFolders[$childFolder->getName()]['files'] = $this->traverseFiles($client, $childFolder->getFiles());

            if ($childFolder->getChildFolders()->isEmpty() !== true) {
                $subFolders[$childFolder->getName()]['folders'][] = $this->sortSubFolders($client, $childFolder->getChildFolders());
            }
        }

        return $subFolders;
    }

    private function traverseFiles(Client $client, Collection $files): array
    {
        return $this->sortByYearAndMonthResolver->resolve($client, $files);
    }
}
