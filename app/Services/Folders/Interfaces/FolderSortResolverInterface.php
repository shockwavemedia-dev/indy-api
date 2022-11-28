<?php

declare(strict_types=1);

namespace App\Services\Folders\Interfaces;

use App\Models\Client;

interface FolderSortResolverInterface
{
    public function resolve(Client $client): array;
}
