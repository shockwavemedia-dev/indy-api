<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ClientService extends AbstractModel
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $casts = [
        'extras' => 'array',
        'is_enabled' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'extras',
        'client_id',
        'service_id',
        'marketing_quota',
        'extra_quota',
        'total_used',
        'is_enabled',
        'created_by',
        'updated_by'
    ];

    protected $table = 'client_services';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getClientId(): int
    {
        return $this->getAttribute('client_id');
    }

    public function getExtras(): array
    {
        return $this->getAttribute('extras')  ?? [];
    }

    public function getMarketingQuota(): int
    {
        return $this->getAttribute('marketing_quota') ?? 0;
    }

    public function getExtraQuota(): int
    {
        return $this->getAttribute('extra_quota') ?? 0;
    }

    public function getTotalUsed(): int
    {
        return $this->getAttribute('total_used') ?? 0;
    }

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getService(): Service
    {
        /** @var \App\Models\Service $service */
        $service = $this->service;

        return $service;
    }

    public function getServiceId(): int
    {
        return $this->getAttribute('service_id');
    }

    public function getUpdatedById(): ?int
    {
        return $this->getAttribute('updated_by');
    }

    public function isEnabled(): bool
    {
        return $this->getAttribute('is_enabled') ?? false;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setCreatedBy(UserTypeEnum $status): self
    {
        $this->setAttribute('created_by', $status->getValue());

        return $this;
    }

    public function setUpdatedBy(?int $updatedBy = null): self
    {
        $this->setAttribute('updated_by', $updatedBy);

        return $this;
    }
    public function markAsEnabled(bool $markAsEnabled): self
    {
        $this->setAttribute('is_enabled', $markAsEnabled);

        return $this;
    }

    public function setMarketingQuota(?int $marketingQuota = null): self
    {
        $this->setAttribute('marketing_quota', $marketingQuota);

        return $this;
    }

    public function setExtraQuota(?int $extraQuota = null): self
    {
        $this->setAttribute('extra_quota', $extraQuota);

        return $this;
    }

    public function setTotalUsed(int $totalUsed): self
    {
        $this->setAttribute('total_used', $totalUsed);

        return $this;
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function setExtras(?array $extras = []): self
    {
        $this->setAttribute('extras', $extras);

        return $this;
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
