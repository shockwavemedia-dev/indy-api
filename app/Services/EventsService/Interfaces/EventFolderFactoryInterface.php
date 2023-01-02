<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Event;
use App\Models\Folder;

interface EventFolderFactoryInterface
{
    public function make(Event $event): Folder;
}
