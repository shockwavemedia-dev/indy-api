<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface FolderRepositoryInterface
{
    public function deleteFolder(Folder $folder, User $user): void;

    public function findByClientAndName(Client $client, string $name): ?Folder;

    public function findParentFoldersByClient(Client $client): Collection;

    public function updateFolder(
        Folder $folder,
        User $user,
        string $name,
        ?Folder $parentFolder = null
    ): Folder;
}
