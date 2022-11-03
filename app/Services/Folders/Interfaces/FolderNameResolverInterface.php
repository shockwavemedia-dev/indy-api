<?php

namespace App\Services\Folders\Interfaces;

use App\Models\Client;
use App\Models\Folder;

interface FolderNameResolverInterface
{
    public function resolve(
        Client $client,
        string $name,
        ?Folder $parentFolder
    ): string;
}
