<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Events;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Event;

final class EventResource extends Resource
{
    /**
     * @var ?string
     */
    public static $wrap = null;

    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Event) === false) {
            throw new InvalidResourceTypeException(
                Event::class
            );
        }

        /** @var Event $event */
        $event = $this->resource;

        $stylingRequired = $event->isStylingRequired();

        if ($stylingRequired !== null) {
            $stylingRequired = $stylingRequired ? 'Yes' : 'No';
        }

        return [
            'id' => $event->getId(),
            'backdrops' => $event->getBackDrops(),
            'booking_type' => $event->getBookingType(),
            'contact_name' => $event->getContactName(),
            'contact_number' => $event->getContactNumber(),
            'department_manager' => $event->getDepartmentManager() ?? '',
            'event_name' => $event->getEventName(),
            'job_description' => $event->getJobDescription(),
            'location' => $event->getLocation(),
            'number_of_dishes' => $event->getNumberOfDishes(),
            'outputs' => $event->getOutputs(),
            'preferred_due_date' => $event->getPreferredDueDate(),
            'service_type' => $event->getServiceType(),
            'shoot_date' => $event->getShootDate(),
            'shoot_title' => $event->getShootTitle(),
            'start_time' => $event->getStartTime(),
            'styling_required' => $stylingRequired,
            'shoot_type' => $event->getShootType(),
            'photographer_id' => $event->getPhotographer()?->getId(),
            'photographer_name' => $event->getPhotographer()?->getUser()->getFullName(),
            'created_by' => \sprintf(
                '%s %s %s',
                $event->getCreatedBy()->getFirstName(),
                $event->getCreatedBy()->getMiddleName(),
                $event->getCreatedBy()->getLastName(),
            ),
            'updated_by' => \sprintf(
                '%s %s %s',
                $event->getUpdatedBy()?->getFirstName(),
                $event->getUpdatedBy()?->getMiddleName(),
                $event->getUpdatedBy()?->getLastName(),
            ),
            'files' => $event->getFolder()?->getFiles() ?? [],
        ];
    }
}
