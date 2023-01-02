<?php

declare(strict_types=1);

namespace App\Services\EventsService\Factories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\EventsService\Interfaces\EventFactoryInterface;
use App\Services\EventsService\Resources\CreateEventResource;

final class EventFactory implements EventFactoryInterface
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function make(CreateEventResource $resource): Event
    {
        /** @var Event $event */
        $event = $this->eventRepository->create([
            'client_id' => $resource->getClient()->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'backdrops' => $resource->getBackDrops(),
            'booking_type' => $resource->getBookingType(),
            'contact_name' => $resource->getContactName(),
            'contact_number' => $resource->getContactNumber(),
            'department_manager' => $resource->getDepartmentManager(),
            'event_name' => $resource->getEventName(),
            'job_description' => $resource->getJobDescription(),
            'location' => $resource->getLocation(),
            'number_of_dishes' => $resource->getNumberOfDishesEnum(),
            'outputs' => $resource->getOutputs(),
            'preferred_due_date' => $resource->getPreferredDueDate(),
            'service_type' => $resource->getServiceTypesEnum()->getValue(),
            'shoot_date' => $resource->getShootDate(),
            'shoot_title' => $resource->getShootTitle(),
            'start_time' => $resource->getStartTime(),
            'styling_required' => $resource->isStylingRequired(),
            'shoot_type' => $resource->getShootType(),
            'photographer_id' => $resource->getPhotographer()?->getId(),
        ]);

        return $event;
    }
}
