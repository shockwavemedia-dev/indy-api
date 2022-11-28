<?php

namespace App\Models\Users;

use App\Enum\UserTypeEnum;
use App\Models\AbstractModel;
use App\Models\User;
use App\Models\Users\Interfaces\UserTypeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class LeadClient extends AbstractModel implements UserTypeInterface
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_name',
        'full_name',
    ];

    protected $table = 'lead_clients';

    public function getCompanyName(): string
    {
        return $this->getAttribute('company_name');
    }

    public function getFullName(): string
    {
        return $this->getAttribute('full_name');
    }

    public function getRole(): string
    {
        return 'n/a';
    }

    public function getType(): UserTypeEnum
    {
        return new UserTypeEnum(UserTypeEnum::LEAD_CLIENT);
    }

    public function setCompanyName(string $companyName): self
    {
        $this->setAttribute('company_name', $companyName);

        return $this;
    }

    public function setFullName(string $fullName): self
    {
        $this->setAttribute('full_name', $fullName);

        return $this;
    }

    public function setRole(string $role): self
    {
        // not applicable
        return $this;
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'morphable');
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
