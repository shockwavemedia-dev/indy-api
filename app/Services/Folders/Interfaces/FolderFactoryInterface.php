<?php

namespace App\Services\Folders\Interfaces;

use App\Models\Folder;
use App\Services\Folders\Resources\CreateFolderResource;

interface FolderFactoryInterface
{
    public function make(CreateFolderResource $resource): Folder;
}
