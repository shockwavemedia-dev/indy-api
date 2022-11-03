<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\AdminRoleEnum;
use App\Enum\DepartmentStatusEnum;
use App\Models\Users\AdminUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Department extends AbstractModel
{
    use SoftDeletes, HasFactory;

    /**
     * @var string
     */
    public const ADMIN_PIVOT_TABLE = 'admin_departments';

    /**
     * @var string
     */
    public const SERVICE_PIVOT_TABLE = 'department_services';

    /**
     * @var string[]
     */
    protected $casts = [];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'min_delivery_days'
    ];

    protected $table = 'departments';

    public function getName(): string
    {
        return $this->attributes('name');
    }

    public function getDescription(): ?string
    {
        return $this->attributes('description');
    }

    public function getMinDeliveryDays(): ?int
    {
        return $this->attributes('min_delivery_days');
    }

    public function getStatus(): DepartmentStatusEnum
    {
        $status = $this->getAttribute('status');

        return new DepartmentStatusEnum($status);
    }

    public function getServices(): ?Collection
    {
        return $this->services;
    }

    public function getAdminUsers(): ?Collection
    {
        return $this->adminUsers;
    }

    public function getStaffs(): ?Collection
    {
        return $this->adminUsers()
            ->where('admin_role', '=', AdminRoleEnum::STAFF)
            ->get();
    }

    public function setDescription(?string $description = null): self
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    public function setMinimumDeliveryDays(int $minimumDays = 0): self
    {
        $this->setAttribute('min_delivery_days', $minimumDays);

        return $this;
    }

    public function setName(string $name): self
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function setStatus(DepartmentStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function adminUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            AdminUser::class,
            self::ADMIN_PIVOT_TABLE,
            'department_id',
            'admin_user_id',
        );
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            self::SERVICE_PIVOT_TABLE,
            'department_id',
            'service_id',
        );
    }
}
