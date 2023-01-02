<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Event;
use App\Services\EventsService\Resources\CreateEventResource;

interface EventFactoryInterface
{
    public function make(CreateEventResource $resource): Event;
}
