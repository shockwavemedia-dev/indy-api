<?php

namespace App\Models;

use App\Enum\EventBookingTypesEnum;
use App\Enum\EventServiceTypesEnum;
use App\Models\Traits\HasRelationshipWithUser;
use App\Models\Users\AdminUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Event extends AbstractModel
{
    use HasFactory, HasRelationshipWithUser, SoftDeletes;


    /**
     * @var string[]
     */
    protected  $casts = [
        'outputs' => 'array',
        'shoot_type' => 'array',
        'styling_required' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_id',
        'created_by',
        'folder_id',
        'updated_by',
        'backdrops',
        'booking_type',
        'contact_name',
        'contact_number',
        'department_manager',
        'event_name',
        'job_description',
        'location',
        'number_of_dishes',
        'outputs',
        'preferred_due_date',
        'service_type',
        'shoot_date',
        'shoot_title',
        'start_time',
        'styling_required',
        'photographer_id',
        'shoot_type',
    ];

    /**
     * @var string
     */
    protected $table = 'events';

    public function getBackDrops(): ?string
    {
        return $this->getAttribute('backdrops');
    }

    public function getBookingType(): EventBookingTypesEnum
    {
        $type = $this->getAttribute('booking_type');

        return new EventBookingTypesEnum($type);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getContactName(): ?string
    {
        return $this->getAttribute('contact_name');
    }

    public function getContactNumber(): ?string
    {
        return $this->getAttribute('contact_number');
    }

    public function getDepartmentManager(): ?string
    {
        return $this->getAttribute('department_manager');
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function getEventName(): string
    {
        return $this->getAttribute('event_name');
    }

    public function getJobDescription(): ?string
    {
        return $this->getAttribute('job_description');
    }

    public function getLocation(): ?string
    {
        return $this->getAttribute('location');
    }

    public function getNumberOfDishes(): ?string
    {
        return $this->getAttribute('number_of_dishes');
    }

    public function getOutputs(): array
    {
        return $this->getAttribute('outputs');
    }

    public function getPhotographer(): ?AdminUser
    {
        return $this->photographer;
    }

    public function getPreferredDueDate(): ?Carbon
    {
        $dueDate = $this->getAttribute('preferred_due_date');

        if ($dueDate === null) {
            return null;
        }

        return new Carbon($dueDate);
    }

    public function getServiceType(): EventServiceTypesEnum
    {
        return new EventServiceTypesEnum($this->getAttribute('service_type'));
    }

    public function getShootDate(): ?Carbon
    {
        $shootDate = $this->getAttribute('shoot_date');

        if ($shootDate === null) {
            return null;
        }

        return new Carbon($shootDate);
    }

    public function getShootTitle(): string
    {
        return $this->getAttribute('shoot_title');
    }

    public function getStartTime(): ?string
    {
        return $this->getAttribute('start_time');
    }

    public function isStylingRequired(): ?bool
    {
        return $this->getAttribute('styling_required');
    }

    public function getShootType(): array
    {
        return $this->getAttribute('shoot_type');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function photographer(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'photographer_id');
    }
}
