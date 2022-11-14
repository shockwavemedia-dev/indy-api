<?php

declare(strict_types=1);

namespace App\Http\Resources\API\PrinterJobs;

use App\Http\Resources\Resource;
use App\Models\PrinterJob;
use App\Models\PrinterJobAttachment;

final class PrinterJobResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->resource;

        $result = [
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
            'stocks' => $printerJob->getAttribute('stocks'),
            'coding' => $printerJob->getAttribute('coding'),
            'address' => $printerJob->getAttribute('address'),
            'purchase_order_number' => $printerJob->getAttribute('purchase_order_number'),
            'description' => $printerJob->getAttribute('description'),
            'client' => $printerJob->client,
            'printer' => $printerJob->printer,
            'created_by' => $printerJob->getCreatedBy()->getFullName(),
        ];

        $attachments = [];

        /** @var PrinterJobAttachment $attachment */
        foreach ($printerJob->getAttachments() as $attachment) {
            $attachments[] = [
                'name' =>  $attachment->getFile()?->getOriginalFilename(),
                'file_type' =>  $attachment->getFile()?->getFileType(),
                'printer_job_attachment_id' => $attachment->getId(),
                'url' => $attachment->getFile()?->getUrl(),
                'thumbnail_url' => $attachment->getFile()?->getThumbnailUrl(),
            ];
        }

        $result['attachments'] = $attachments;

        return $result;
    }
}
