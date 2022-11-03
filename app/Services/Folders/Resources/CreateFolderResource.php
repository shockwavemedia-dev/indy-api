<?php

declare(strict_types=1);

namespace App\Services\Folders\Resources;

use App\Models\Client;
use App\Models\Folder;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateFolderResource extends DataTransferObject
{
    public Client $client;

    public ?Folder $parentFolder = null;

    public User $createdBy;

    public string $name;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getParentFolder(): ?Folder
    {
        return $this->parentFolder;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
