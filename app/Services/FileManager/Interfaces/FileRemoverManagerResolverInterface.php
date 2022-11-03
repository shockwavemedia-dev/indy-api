<?php

namespace App\Services\FileManager\Interfaces;

use App\Models\File;
use App\Models\User;

interface FileRemoverManagerResolverInterface
{
    public function remove(File $file, User $user): void;

    public function supports(string $driver): bool;
}
