<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resources;

use App\Enum\SocialMediaStatusesEnum;
use App\Models\Client;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateSocialMediaResource extends DataTransferObject
{
    public ?Ticket $ticket;

    public ?Carbon $postDate;

    public Client $client;

    public SocialMediaStatusesEnum $status;

    public User $createdBy;

    public ?string $campaignType = null;

    public string $post;

    public ?string $copy = null;

    /**
     * @return string|null
     */
    public function getCampaignType(): ?string
    {
        return $this->campaignType;
    }

    public ?string $notes = null;

    public array $channels;

    /**
     * @return Ticket|null
     */
    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }


    /**
     * @return Carbon
     */
    public function getPostDate(): ?Carbon
    {
        return $this->postDate;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return SocialMediaStatusesEnum
     */
    public function getStatus(): SocialMediaStatusesEnum
    {
        return $this->status;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getPost(): string
    {
        return $this->post;
    }

    /**
     * @return string|null
     */
    public function getCopy(): ?string
    {
        return $this->copy;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}
