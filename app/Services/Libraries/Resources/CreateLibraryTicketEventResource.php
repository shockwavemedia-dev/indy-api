<?php

declare(strict_types=1);

namespace App\Services\Libraries\Resources;

use App\Models\Users\ClientUser;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateLibraryTicketEventResource extends DataTransferObject
{
    public ClientUser $clientUser;

    public ?string $description = null;

    public int $libraryId;

    /**
     * @return ClientUser
     */
    public function getClientUser(): ClientUser
    {
        return $this->clientUser;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getLibraryId(): int
    {
        return $this->libraryId;
    }

    /**
     * @param ClientUser $clientUser
     * @return CreateLibraryTicketEventResource
     */
    public function setClientUser(ClientUser $clientUser): self
    {
        $this->clientUser = $clientUser;
        return $this;
    }

    /**
     * @param string|null $description
     * @return CreateLibraryTicketEventResource
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param int $libraryId
     * @return CreateLibraryTicketEventResource
     */
    public function setLibraryId(int $libraryId): self
    {
        $this->libraryId = $libraryId;
        return $this;
    }
}
