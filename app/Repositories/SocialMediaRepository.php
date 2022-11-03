<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class SocialMediaRepository extends BaseRepository implements SocialMediaRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new SocialMedia());
    }

    public function findByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model->where('client_id', $client->getId())
            ->with([
                'attachments.file',
                'comments',
                'activities',
            ])
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function update(SocialMedia $socialMedia, array $updates): SocialMedia
    {
        $socialMedia->update($updates);

        $socialMedia->refresh();

        return $socialMedia;
    }

    public function findByClientMonthAndYear(Client $client, int $month, int $year): Collection
    {
        return $this->model
            ->whereMonth('post_date', $month)
            ->whereYear('post_date',  $year)
            ->where('client_id', $client->getId())
            ->with('attachments.file')
            ->get();
    }
}
