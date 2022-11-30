<?php

declare(strict_types=1);

namespace App\Services\EventsService\Resolvers;

use App\Models\Event;
use App\Models\User;
use App\Services\EventsService\Interfaces\EventUpdateResolverInterface;
use Carbon\Carbon;

final class EventUpdateResolver implements EventUpdateResolverInterface
{
    public function resolve(Event $event, User $user, array $updates): Event
    {
        if ($event->getPhotographer() !== null && isset($updates['photographer_id']) === true) {
            $event->photographer_id = $updates['photographer_id'];
        }

        if (isset($updates['shoot_date']) === true) {
            $updates['shoot_date'] = new Carbon($updates['shoot_date']);
        }

        if ($updates['styling_required'] !== null) {
            $updates['styling_required'] = $updates['styling_required'] === 'Yes' ? 1 : 0;
        }

        if (isset($updates['preferred_due_date']) === true) {
            $updates['preferred_due_date'] = new Carbon($updates['preferred_due_date']);
        }

        $updates['updated_by'] = $user->getId();

        $event->update($updates);
        $event->save();

        return $event;
    }
}
