<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Screens;

use App\Http\Resources\Resource;

final class ScreenResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getAttribute('name'),
            'slug' => $this->resource->getAttribute('slug'),
            'logo' => $this->resource->getLogoFile(),
            'created_by' => $this->resource->getCreatedBy()->getFullName(),
        ];
    }
}
