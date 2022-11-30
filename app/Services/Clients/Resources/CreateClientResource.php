<?php

declare(strict_types=1);

namespace App\Services\Clients\Resources;

use App\Enum\ClientStatusEnum;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateClientResource extends DataTransferObject
{
    public string $name;

    public string $clientCode;

    public ?int $logoFileId;

    public string $address;

    public string $phone;

    public string $timezone;

    public DateTimeInterface $clientSince;

    public ?int $mainClientId;

    public string $overview;

    public ?int $rating;

    public ClientStatusEnum $status;

    public ?int $designatedDesignerId;

    public ?string $note = null;

    public ?string $styleGuide = null;

    public ?int $designatedAnimatorId = null;

    public ?int $designatedWebEditorId = null;

    public ?int $designatedSocialMediaManagerId = null;

    public ?int $designatedPrinterManagerId = null;

    public function getDesignatedAnimatorId(): ?int
    {
        return $this->designatedAnimatorId;
    }

    public function setDesignatedAnimatorId(?int $designatedAnimatorId): self
    {
        $this->designatedAnimatorId = $designatedAnimatorId;

        return $this;
    }

    public function getDesignatedWebEditorId(): ?int
    {
        return $this->designatedWebEditorId;
    }

    public function setDesignatedWebEditorId(?int $designatedWebEditorId): self
    {
        $this->designatedWebEditorId = $designatedWebEditorId;

        return $this;
    }

    public function getDesignatedSocialMediaManagerId(): ?int
    {
        return $this->designatedSocialMediaManagerId;
    }

    public function setDesignatedSocialMediaManagerId(?int $designatedSocialMediaManagerId): self
    {
        $this->designatedSocialMediaManagerId = $designatedSocialMediaManagerId;

        return $this;
    }

    public function getDesignatedPrinterManagerId(): ?int
    {
        return $this->designatedPrinterManagerId;
    }

    public function setDesignatedPrinterManagerId(?int $designatedPrinterManagerId): self
    {
        $this->designatedPrinterManagerId = $designatedPrinterManagerId;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getStyleGuide(): ?string
    {
        return $this->styleGuide;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClientCode(): string
    {
        return $this->clientCode;
    }

    public function getLogoFileId(): ?int
    {
        return $this->logoFileId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getClientSince(): DateTimeInterface
    {
        return $this->clientSince;
    }

    public function getMainClientId(): ?int
    {
        return $this->mainClientId;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getStatus(): string
    {
        return $this->status->getValue();
    }

    public function getDesignatedDesignerId(): ?int
    {
        return $this->designatedDesignerId;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setClientCode(string $clientCode): self
    {
        $this->clientCode = $clientCode;

        return $this;
    }

    public function setLogoFileId(?int $logoFileId): self
    {
        $this->logoFileId = $logoFileId;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function setClientSince(DateTimeInterface $clientSince): self
    {
        $this->clientSince = $clientSince;

        return $this;
    }

    public function setMainClientId(?int $mainClientId): self
    {
        $this->mainClientId = $mainClientId;

        return $this;
    }

    public function setOverview(string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function setStatus(ClientStatusEnum $status): self
    {
        $this->status = $status->getValue();

        return $this;
    }

    public function setDesignatedDesignerId(?int $designatedDesignerId): self
    {
        $this->designatedDesignerId = $designatedDesignerId;

        return $this;
    }
}
