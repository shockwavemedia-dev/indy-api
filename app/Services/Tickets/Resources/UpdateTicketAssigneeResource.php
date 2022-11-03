<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use App\Enum\TicketAssigneeStatusEnum;
use App\Models\Users\AdminUser;
use Spatie\DataTransferObject\DataTransferObject;

final class UpdateTicketAssigneeResource extends DataTransferObject
{
    public ?TicketAssigneeStatusEnum $statusEnum = null;

    public ?AdminUser $adminUser = null;

    public function getStatusEnum(): ?TicketAssigneeStatusEnum
    {
        return $this->statusEnum;
    }

    public function setStatusEnum(?TicketAssigneeStatusEnum $statusEnum): self
    {
        $this->statusEnum = $statusEnum;
        return $this;
    }

    public function getAdminUser(): ?AdminUser
    {
        return $this->adminUser;
    }

    public function setAdminUser(?AdminUser $adminUser): self
    {
        $this->adminUser = $adminUser;
        return $this;
    }
}
