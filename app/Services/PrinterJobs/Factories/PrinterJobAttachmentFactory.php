<?php

declare(strict_types=1);

namespace App\Services\PrinterJobs\Factories;

use App\Repositories\Interfaces\PrinterJobAttachmentRepositoryInterface;
use App\Services\PrinterJobs\Interfaces\PrinterJobAttachmentFactoryInterface;
use App\Services\PrinterJobs\Resources\CreateAttachmentResource;

final class PrinterJobAttachmentFactory implements PrinterJobAttachmentFactoryInterface
{
    private PrinterJobAttachmentRepositoryInterface $printerJobAttachmentRepository;

    public function __construct(PrinterJobAttachmentRepositoryInterface $printerJobAttachmentRepository) {
        $this->printerJobAttachmentRepository = $printerJobAttachmentRepository;
    }

    public function make(CreateAttachmentResource $resource): void
    {
        $this->printerJobAttachmentRepository->create([
            'printer_job_id' => $resource->getPrinterJob()->getId(),
            'file_id' => $resource->getFile()->getId(),
        ]);
    }
}
