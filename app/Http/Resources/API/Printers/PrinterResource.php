<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Printers;

use App\Http\Resources\Resource;
use App\Models\Printer;

final class PrinterResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        /** @var Printer $printer */
        $printer = $this->resource;

        return [
            'id' => $printer->getId(),
            'email' => $printer->getUser()->getEmail(),
            'company_name' => $printer->getAttribute('company_name'),
            'created_by' => $printer->getCreatedBy()->getFullName(),
            'contact_name' => $printer->getAttribute('contact_name'),
            'phone' => $printer->getAttribute('phone'),
            'description' => $printer->getAttribute('description'),
            'company_logo_url' => $printer->getFile()?->getUrl(),
            'company_thumbnail_logo_url' => $printer->getFile()?->getThumbnailUrl(),
            'created_at' => $printer->getCreatedAtAsString(),
        ];
    }
}
