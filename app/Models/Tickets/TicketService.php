<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class TicketService extends AbstractModel
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $casts = [
        'custom_fields' => 'array',
        'extras' => 'array',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'extras',
        'custom_fields',
        'ticket_id',
        'service_id',
        'created_by',
        'post_date',
        'updated_by',
    ];

    protected $table = 'ticket_services';

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getCustomFields(): ?array
    {
        return $this->getAttribute('custom_fields');
    }

    public function getExtras(): array
    {
        return $this->getAttribute('extras') ?? [];
    }

    public function getPostDate(): ?Carbon
    {
        $postDate = $this->getAttribute('post_date');

        if ($postDate === null) {
            return null;
        }

        return new Carbon($postDate);
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function getServiceId(): int
    {
        return $this->getAttribute('service_id');
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getTicketEventId(): int
    {
        return $this->getAttribute('ticket_event_id');
    }

    public function getUpdatedById(): int
    {
        return $this->getAttribute('updated_by');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
