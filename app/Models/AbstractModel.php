<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    public function attributes(string $field)
    {
        return $this->attributes[$field] ?? null;
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getCreatedAt(): ?Carbon
    {
        $date = $this->attributes('created_at');

        if ($date === null) {
            return null;
        }

        return new Carbon($date);
    }

    public function getUpdatedAtAsString(): ?string
    {
        return $this->getUpdatedAt()?->toDateTimeString();
    }

    public function getUpdatedAt(): ?Carbon
    {
        $date = $this->attributes('updated_at');

        if ($date === null) {
            return null;
        }

        return new Carbon($date);
    }

    public function getCreatedAtAsString(): ?string
    {
        return $this->getCreatedAt()?->toDateTimeString();
    }
}
