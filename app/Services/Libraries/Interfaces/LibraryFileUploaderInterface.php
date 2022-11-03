<?php

declare(strict_types=1);

namespace App\Services\Libraries\Interfaces;

use App\Services\Libraries\Resources\LibraryProcessResource;

interface LibraryFileUploaderInterface
{
    public function upload(LibraryProcessResource $resource): void;
}
