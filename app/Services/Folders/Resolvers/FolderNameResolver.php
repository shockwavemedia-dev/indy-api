<?php

declare(strict_types=1);

namespace App\Services\Folders\Resolvers;

use App\Models\Client;
use App\Models\Folder;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use App\Services\Folders\Interfaces\FolderNameResolverInterface;
use Illuminate\Database\Eloquent\Collection;
use function sprintf;

final class FolderNameResolver implements FolderNameResolverInterface
{
    private FolderRepositoryInterface $folderRepository;

    private string $name;

    public function __construct(FolderRepositoryInterface $folderRepository) {
        $this->folderRepository = $folderRepository;
    }

    public function resolve(
        Client $client,
        string $name,
        ?Folder $parentFolder
    ): string {
        $existingFolders = $parentFolder?->getChildFolders();

        if ($parentFolder === null) {
            $existingFolders = $this->folderRepository->findParentFoldersByClient($client);
        }

        if ($existingFolders->isEmpty() === true) {
            return $name;
        }

        $this->name = $name;

        $this->nameExistResolver(
            $existingFolders,
            $name,
        );

        return $this->name;
    }

    private function nameExistResolver(
        ?Collection $children,
        string $name,
        int &$counter = 0
    ): void {
        $counter = ++$counter;

        $childExist = $children->firstWhere(
            'name',
            $name,
        );

        if ($childExist === null) {
            $this->name = $name;

            return;
        }

        $name = sprintf('%s(%s)', $this->name, $counter);

        $this->nameExistResolver($children, $name, $counter);
    }
}
