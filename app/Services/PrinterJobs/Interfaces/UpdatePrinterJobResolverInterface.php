<?php

namespace App\Services\PrinterJobs\Interfaces;

use App\Models\PrinterJob;

interface UpdatePrinterJobResolverInterface
{
    public function resolve(PrinterJob $printerJob, array $changes): PrinterJob;
}
