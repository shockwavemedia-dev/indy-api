<?php

declare(strict_types=1);

namespace App\Models\Users;

use App\Enum\TicketStatusEnum;
use App\Enum\UserTypeEnum;
use App\Models\AbstractModel;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\User;
use App\Models\Users\Interfaces\UserTypeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class AdminUser extends AbstractModel implements UserTypeInterface
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'admin_role',
    ];

    protected $table = 'admin_users';

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function getRole(): string
    {
        return $this->attributes('admin_role');
    }

    public function getType(): UserTypeEnum
    {
        return new UserTypeEnum(UserTypeEnum::ADMIN);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param  int[]  $ids
     */
    public function setDepartments(array $ids): self
    {
        $this->departments()->attach($ids);

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->setAttribute('admin_role', $role);

        return $this;
    }

    public function getOpenTickets(): int
    {
        return $this->tickets()->where('tickets.status', TicketStatusEnum::OPEN)->count();
    }

    public function getClosedTicketsBy30Days(): int
    {
        $dateToday = new Carbon();

        $dateLast30Days = $dateToday->subDays(30);

        return $this->tickets()
            ->whereBetween('tickets.created_at', [$dateLast30Days, $dateToday])
            ->where('tickets.status', TicketStatusEnum::CLOSED)
            ->count();
    }

    public function getClosedTicketsBy90Days(): int
    {
        $dateToday = new Carbon();

        $dateLast90Days = $dateToday->subDays(90);

        return $this->tickets()
            ->whereBetween('tickets.created_at', [$dateLast90Days, $dateToday])
            ->where('tickets.status', TicketStatusEnum::CLOSED)
            ->count();
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            Department::class,
            Department::ADMIN_PIVOT_TABLE,
            'admin_user_id',
            'department_id',
        )->withPivot('position');
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'morphable');
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(TicketAssignee::class, 'admin_user_id');
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(
            TicketAssignee::class,
            Ticket::class,
            'id',
            'admin_user_id',
            'id',
        );
    }
}
