<?php

namespace App\Services\PrinterJobs\Interfaces;

use App\Services\PrinterJobs\Resources\CreateAttachmentResource;

interface PrinterJobAttachmentFactoryInterface
{
    public function make(CreateAttachmentResource $resource): void;
}
