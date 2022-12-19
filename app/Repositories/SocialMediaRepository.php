<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
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
            ->orderBy('id', 'desc')
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
        $startDate = new Carbon(sprintf('%s-%s-%s',
            $year,
            $month,
            '1',
        ));

        $startDate = $startDate->subDay()->startOfDay();

        $endDate = $startDate->endOfMonth()->addDay()->endOfDay();

        return $this->model
            ->where('post_date', '>=', $startDate->toDateTimeString())
            ->where('post_date', '<', $endDate->toDateTimeString())
            ->where('client_id', $client->getId())
            ->with('attachments.file')
            ->get();
    }
}
