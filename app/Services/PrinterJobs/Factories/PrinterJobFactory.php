<?php

declare(strict_types=1);

namespace App\Services\PrinterJobs\Factories;

use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\PrinterJobs\Interfaces\PrinterJobFactoryInterface;
use App\Services\PrinterJobs\Resources\CreatePrinterJobResource;

final class PrinterJobFactory implements PrinterJobFactoryInterface
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(PrinterJobRepositoryInterface $printerJobRepository)
    {
        $this->printerJobRepository = $printerJobRepository;
    }

    public function make(CreatePrinterJobResource $resource): PrinterJob
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->create([
            'client_id' => $resource->getClient()->getId(),
            'printer_id' => $resource->getPrinterId(),
            'status' => $resource->getStatus()->getValue(),
            'customer_name' => $resource->getCustomerName(),
            'product' => $resource->getProduct(),
            'option' => $resource->getOption(),
            'kinds' => $resource->getKinds(),
            'quantity' => $resource->getQuantity(),
            'run_ons' => $resource->getRunOns(),
            'format' => $resource->getFormat(),
            'final_trim_size' => $resource->getFinalTrimSize(),
            'reference' => $resource->getReference(),
            'notes' => $resource->getNotes(),
            'additional_options' => $resource->getAdditionalOptions(),
            'delivery' => $resource->getDelivery(),
            'price' => $resource->getPrice(),
            'blind_shipping' => $resource->getBlindShipping(),
            'reseller_samples' => $resource->getResellerSamples(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'stocks' => $resource->getStocks(),
            'coding' => $resource->getCoding(),
            'address' => $resource->getAddress(),
            'purchase_order_number' => $resource->getPurchaseOrderNumber(),
            'description' => $resource->getDescription(),
        ]);

        return $printerJob;
    }
}
