<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

use App\Models\File;
use App\Models\User;

interface FileRemoverInterface
{
    public function delete(File $file, User $user): void;
}
