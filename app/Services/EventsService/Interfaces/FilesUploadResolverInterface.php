<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Event;
use App\Models\User;

interface FilesUploadResolverInterface
{
    public function resolve(Event $event, User $user, array $files): void;
}
