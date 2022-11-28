<?php

declare(strict_types=1);

namespace App\Services\PrinterJobs\Resources;

use App\Enum\PrinterJobStatusesEnum;
use App\Models\Client;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePrinterJobResource extends DataTransferObject
{
    public Client $client;

    public ?int $printerId = null;

    public PrinterJobStatusesEnum $status;

    public ?string $customerName = null;

    public ?string $product = null;

    public ?string $option = null;

    public ?string $kinds = null;

    public ?string $quantity = null;

    public ?string $runOns = null;

    public ?string $format = null;

    public ?array $finalTrimSize = null;

    public ?string $reference = null;

    public ?string $notes = null;

    public ?array $additionalOptions = null;

    public ?string $delivery = null;

    public ?string $price = null;

    public $blindShipping = null;

    public $resellerSamples = null;

    public ?string $stocks = null;

    public ?string $coding = null;

    public ?string $address = null;

    public ?string $purchaseOrderNumber = null;

    public ?string $description = null;

    public User $createdBy;

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getPrinterId(): ?int
    {
        return $this->printerId;
    }

    /**
     * @return PrinterJobStatusesEnum
     */
    public function getStatus(): PrinterJobStatusesEnum
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    /**
     * @return string|null
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * @return string|null
     */
    public function getOption(): ?string
    {
        return $this->option;
    }

    /**
     * @return string|null
     */
    public function getKinds(): ?string
    {
        return $this->kinds;
    }

    /**
     * @return string|null
     */
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getRunOns(): ?string
    {
        return $this->runOns;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @return array|null
     */
    public function getFinalTrimSize(): ?array
    {
        return $this->finalTrimSize;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return array|null
     */
    public function getAdditionalOptions(): ?array
    {
        return $this->additionalOptions;
    }

    /**
     * @return string|null
     */
    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @return int|null
     */
    public function getBlindShipping(): bool
    {
        return filter_var($this->blindShipping ?? null, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return int|null
     */
    public function getResellerSamples(): bool
    {
        return filter_var($this->resellerSamples ?? null, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return string|null
     */
    public function getStocks(): ?string
    {
        return $this->stocks;
    }

    /**
     * @return string|null
     */
    public function getCoding(): ?string
    {
        return $this->coding;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getPurchaseOrderNumber(): ?string
    {
        return $this->purchaseOrderNumber;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
