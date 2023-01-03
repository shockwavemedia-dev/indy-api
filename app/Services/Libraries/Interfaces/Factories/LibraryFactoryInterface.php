<?php

declare(strict_types=1);

namespace App\Services\Libraries\Interfaces\Factories;

use App\Models\Library;
use App\Services\Libraries\Resources\CreateLibraryResource;

interface LibraryFactoryInterface
{
    public function make(CreateLibraryResource $resource): Library;
}
