<?php

namespace App\Services\Folders\Interfaces;

use App\Models\Folder;
use App\Models\User;

interface UploadFileFolderResolverInterface
{
    public function resolve(Folder $folder, User $user, array $files);
}
