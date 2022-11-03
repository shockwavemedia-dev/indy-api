<?php

declare(strict_types=1);

namespace App\Services\Libraries\Interfaces;

use App\Models\Client;
use App\Models\File;

interface LibraryFileFetcherInterface
{
    public function signedUrl(File $file, ?int $expireInMinutes = 60): string;
}
