<?php

declare(strict_types=1);

namespace App\Services\Folders\Interfaces;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface FolderSortResolverInterface
{
    public function resolve(Client $client): array;
}
