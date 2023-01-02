<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Event;

interface EventFileFolderUpdateResolverInterface
{
    public function resolve(Event $event): void;
}
