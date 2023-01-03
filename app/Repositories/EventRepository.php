<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\Event;
use App\Models\User;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Event());
    }

    public function deleteEvent(Event $event, User $user): void
    {
        $event->updatedBy()->associate($user);
        $event->delete();
        $event->save();
    }

    public function findByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->where('client_id', $client->getId())
            ->paginate(
                $size,
                ['*'],
                null,
                $pageNumber
            );
    }

    public function findByClientMonthAndYear(
        Client $client,
        int $month,
        int $year
    ): Collection {
        return $this->model
            ->with('photographer')
            ->whereMonth('shoot_date', $month)
            ->whereYear('shoot_date', $year)
            ->where('client_id', $client->getId())
            ->get();
    }
}
