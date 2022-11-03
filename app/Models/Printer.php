<?php

namespace App\Models;

use App\Enum\AdminRoleEnum;
use App\Enum\UserTypeEnum;
use App\Models\Traits\HasRelationshipWithUser;
use App\Models\Users\Interfaces\UserTypeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends AbstractModel implements UserTypeInterface
{
    use HasFactory, HasRelationshipWithUser, SoftDeletes;

    protected $fillable = [
        'company_name',
        'created_by',
        'contact_name',
        'phone',
        'description',
        'file_id',
    ];

    protected $table = 'printers';

    public function getUser(): User
    {
        return $this->user;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'morphable');
    }

    public function getRole(): string
    {
        return AdminRoleEnum::PRINT_MANAGER;
    }

    public function setRole(string $role): UserTypeInterface
    {
        return $this;
    }

    public function getType(): UserTypeEnum
    {
        return new UserTypeEnum(UserTypeEnum::PRINTER);
    }
}
