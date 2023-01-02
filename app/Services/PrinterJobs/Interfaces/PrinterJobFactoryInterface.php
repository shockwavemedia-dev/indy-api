<?php

namespace App\Services\PrinterJobs\Interfaces;

use App\Models\PrinterJob;
use App\Services\PrinterJobs\Resources\CreatePrinterJobResource;

interface PrinterJobFactoryInterface
{
    public function make(CreatePrinterJobResource $resource): PrinterJob;
}
