<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
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

    public function findByClientMonthAndYear(Client $client, int $month, int $year, string $timezone): Collection
    {
        $monthYear = date("Y-m-t", strtotime($year.'-'.$month));

        $postStartDate =  new DateTime($year.'-'.$month.'-01 00:00:00', new DateTimeZone($timezone));
        $postStartDate->setTimezone(new DateTimeZone('UTC'));

        $postEndDate =  new DateTime($monthYear.' '.'23:59:59', new DateTimeZone($timezone));
        $postEndDate->setTimezone(new DateTimeZone('UTC'));

        return $this->model
            ->where('post_date', '>=', $postStartDate->format('Y-m-d h:i:s'))
            ->where('post_date', '<', $postEndDate->format('Y-m-d h:i:s'))
            ->where('client_id', $client->getId())
            ->with('attachments.file')
            ->get();
    }
}
