<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\Event;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function deleteEvent(Event $event, User $user): void;

    public function findByClient(Client $client): LengthAwarePaginator;

    public function findByClientMonthAndYear(
        Client $client,
        int $month,
        int $year
    ): Collection;
}
