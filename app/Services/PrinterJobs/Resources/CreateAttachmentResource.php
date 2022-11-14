<?php

declare(strict_types=1);

namespace App\Services\PrinterJobs\Resources;

use App\Models\File;
use App\Models\PrinterJob;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateAttachmentResource extends DataTransferObject
{
    public PrinterJob $printerJob;

    public File $file;

    /**
     * @return PrinterJob
     */
    public function getPrinterJob(): PrinterJob
    {
        return $this->printerJob;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }


}
