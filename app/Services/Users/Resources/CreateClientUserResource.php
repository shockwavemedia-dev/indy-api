<?php

declare(strict_types=1);

namespace App\Services\Users\Resources;

use App\Enum\ClientRoleEnum;
use App\Models\Client;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateClientUserResource extends DataTransferObject implements CreateUserTypeResourceInterface
{
    public ClientRoleEnum $role;

    public $client;

    public function getRole(): string
    {
        return $this->role->getValue();
    }

    public function setRole(ClientRoleEnum $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
