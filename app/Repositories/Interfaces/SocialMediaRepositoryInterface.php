<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\SocialMedia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SocialMediaRepositoryInterface
{
    public function findByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findByClientMonthAndYear(
        Client $client,
        int $month,
        int $year
    ): Collection;

    public function update(SocialMedia $socialMedia, array $updates): SocialMedia;
}
