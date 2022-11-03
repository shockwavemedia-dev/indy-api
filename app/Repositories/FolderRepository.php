<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\Folder;
use App\Models\User;
use App\Repositories\Interfaces\FolderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class FolderRepository extends BaseRepository implements FolderRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Folder());
    }

    public function deleteFolder(Folder $folder, User $user): void
    {
        $folder->delete();
        $folder->updatedBy()->associate($user);
        $folder->save();
    }

    public function findByClientAndName(Client $client, string $name): ?Folder
    {
        return $this->model->where('name', $name)
            ->where('client_id', $client->getId())
            ->first();
    }

    public function findParentFoldersByClient(Client $client): Collection
    {
        return $this->model
            ->with(['files.clientTicketFile','parentFolder','childFolders'])
            ->where('client_id', '=', $client->getId())
            ->where('parent_folder_id', null)
            ->get();
    }

    public function updateFolder(
        Folder $folder,
        User $user,
        string $name,
        ?Folder $parentFolder = null
    ): Folder {
        $folder->setAttribute('name', $name);

        if ($parentFolder !== null) {
            $folder->parentFolder()->associate($parentFolder);
        }

        $folder->updatedBy()->associate($user);
        $folder->save();

        return $folder;
    }
}
