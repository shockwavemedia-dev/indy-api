<?php

declare(strict_types=1);

namespace App\Http\Resources\API\PrinterJobs;

use App\Http\Resources\Resource;
use App\Models\PrinterJob;

final class PrinterJobResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->resource;

        return [
            'id' => $printerJob->getId(),
            'is_approved' => $printerJob->getAttribute('is_approved'),
            'status' => $printerJob->getAttribute('status'),
            'customer_name' => $printerJob->getAttribute('customer_name'),
            'product' => $printerJob->getAttribute('product'),
            'option' => $printerJob->getAttribute('option'),
            'kinds' => $printerJob->getAttribute('kinds'),
            'quantity' => $printerJob->getAttribute('quantity'),
            'run_ons' => $printerJob->getAttribute('run_ons'),
            'format' => $printerJob->getAttribute('format'),
            'final_trim_size' => $printerJob->getAttribute('final_trim_size'),
            'reference' => $printerJob->getAttribute('reference'),
            'notes' => $printerJob->getAttribute('notes'),
            'additional_options' => $printerJob->getAttribute('additional_options'),
            'delivery' => $printerJob->getAttribute('delivery'),
            'price' => $printerJob->getAttribute('price'),
            'blind_shipping' => $printerJob->getAttribute('blind_shipping'),
            'reseller_samples' => $printerJob->getAttribute('reseller_samples'),
            'client' => $printerJob->client,
            'printer' => $printerJob->printer,
            'created_by' => $printerJob->getCreatedBy()->getFullName(),
        ];
    }
}
