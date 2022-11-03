<?php

declare(strict_types=1);


namespace App\Services\Graphics\Resources;

use App\Models\User;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateGraphicRequestResource extends DataTransferObject
{
    public User $requestedBy;

    public array $attachments;

    public ?string $description = null;

    public string $subject;

    public array $service;

    /**
     * @return User
     */
    public function getRequestedBy(): User
    {
        return $this->requestedBy;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getService(): array
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param User $requestedBy
     * @return CreateGraphicRequestResource
     */
    public function setRequestedBy(User $requestedBy): self
    {
        $this->requestedBy = $requestedBy;
        return $this;
    }

    /**
     * @param array $attachments
     * @return CreateGraphicRequestResource
     */
    public function setAttachments(array $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * @param string|null $description
     * @return CreateGraphicRequestResource
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param array $service
     * @return CreateGraphicRequestResource
     */
    public function setService(array $service): self
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @param string $subject
     * @return CreateGraphicRequestResource
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }


}
