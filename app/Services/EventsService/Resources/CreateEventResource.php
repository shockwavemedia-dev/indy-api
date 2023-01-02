<?php

declare(strict_types=1);

namespace App\Services\EventsService\Resources;

use App\Enum\EventBookingTypesEnum;
use App\Enum\EventNumberOfDishesEnum;
use App\Enum\EventServiceTypesEnum;
use App\Models\Client;
use App\Models\User;
use App\Models\Users\AdminUser;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateEventResource extends DataTransferObject
{
    public User $createdBy;

    public Client $client;

    public ?AdminUser $photographer = null;

    public ?string $departmentManager = null;

    public string $bookingType;

    public ?string $preferredDueDate = null;

    public string $serviceType;

    public string $shootDate;

    public ?bool $stylingRequired = null;

    public ?User $updatedBy = null;

    public ?string $backdrops = null;

    public ?string $contactName = null;

    public ?string $contactNumber = null;

    public string $eventName;

    public ?string $jobDescription = null;

    public ?string $location = null;

    public ?string $numberOfDishes = null;

    public ?array $outputs = [];

    public string $shootTitle;

    public ?string $startTime = null;

    public ?array $shootType;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function isStylingRequired(): ?bool
    {
        return $this->stylingRequired;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getDepartmentManager(): ?string
    {
        return $this->departmentManager;
    }

    public function getNumberOfDishesEnum(): ?EventNumberOfDishesEnum
    {
        $dishesNumber = $this->numberOfDishes;

        if ($dishesNumber === null) {
            return null;
        }

        return new EventNumberOfDishesEnum($dishesNumber);
    }

    public function getBookingType(): EventBookingTypesEnum
    {
        return new EventBookingTypesEnum($this->bookingType);
    }

    public function getPhotographer(): ?AdminUser
    {
        return $this->photographer;
    }

    public function getPreferredDueDate(): ?Carbon
    {
        if ($this->preferredDueDate === null) {
            return null;
        }

        return new Carbon($this->preferredDueDate);
    }

    public function getServiceTypesEnum(): EventServiceTypesEnum
    {
        return new EventServiceTypesEnum($this->serviceType);
    }

    public function getShootDate(): Carbon
    {
        return new Carbon($this->shootDate);
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function getBackDrops(): ?string
    {
        return $this->backdrops;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getOutputs(): array
    {
        return $this->outputs;
    }

    public function getShootTitle(): string
    {
        return $this->shootTitle;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getShootType(): array
    {
        return $this->shootType ?? [];
    }
}
