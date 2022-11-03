<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Carbon\Carbon;

trait HasDates
{
    public function getCreatedAt(): Carbon
    {
        return $this->getAttributes('created_at');
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->getAttributes('updated_at');
    }
}
