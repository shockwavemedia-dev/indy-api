<?php

declare(strict_types=1);

namespace App\Models\Users;

use App\Enum\UserTypeEnum;
use App\Models\AbstractModel;
use App\Models\Client;
use App\Models\User;
use App\Models\Users\Interfaces\UserTypeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class ClientUser extends AbstractModel implements UserTypeInterface
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_role',
        'client_id',
    ];

    protected $table = 'client_users';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getClientId(): int
    {
        return $this->attributes('client_id');
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getRole(): string
    {
        return $this->getAttribute('client_role');
    }

    public function getType(): UserTypeEnum
    {
        return new UserTypeEnum(UserTypeEnum::CLIENT);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setClient(Client $client): self
    {
        $this->setAttribute('client_id', $client->getId());

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->setAttribute('client_role', $role);

        return $this;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'morphable');
    }
}
