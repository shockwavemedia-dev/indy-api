<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Event;
use App\Models\User;

interface EventUpdateResolverInterface
{
    public function resolve(Event $event, User $user, array $updates): Event;
}
