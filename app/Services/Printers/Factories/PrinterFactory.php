<?php

declare(strict_types=1);

namespace App\Services\Printers\Factories;

use App\Models\Printer;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use App\Services\Printers\Interfaces\PrinterFactoryInterface;
use App\Services\Printers\Resources\CreatePrinterResource;

final class PrinterFactory implements PrinterFactoryInterface
{
    private PrinterRepositoryInterface $printerRepository;

    public function __construct(PrinterRepositoryInterface $printerRepository)
    {
        $this->printerRepository = $printerRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function make(CreatePrinterResource $resource): Printer
    {
        /** @var Printer $printer */
        $printer = $this->printerRepository->create([
            'company_name' => $resource->getCompanyName(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'contact_name' => $resource->getContactName(),
            'phone' => $resource->getPhone(),
            'description' => $resource->getDescription(),
            'file_id' => $resource->getLogo()?->getId(),
        ]);

        return $printer;
    }
}
