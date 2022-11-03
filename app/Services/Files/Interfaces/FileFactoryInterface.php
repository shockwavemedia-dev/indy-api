<?php

declare(strict_types=1);

namespace App\Services\Files\Interfaces;

use App\Models\File;
use App\Services\Files\Resources\CreateFileResource;

interface FileFactoryInterface
{
    public function make(CreateFileResource $resource): File;
}
