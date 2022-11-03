<?php

declare(strict_types=1);

namespace App\Services\Libraries\Interfaces;

use App\Models\File;

interface LibraryFileRemoverInterface
{
    public function delete(File $file): void;
}
