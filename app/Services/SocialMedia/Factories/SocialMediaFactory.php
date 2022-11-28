<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Factories;

use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaFactoryInterface;
use App\Services\SocialMedia\Resources\CreateSocialMediaResource;

final class SocialMediaFactory implements SocialMediaFactoryInterface
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository)
    {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function make(CreateSocialMediaResource $resource): SocialMedia
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->create([
            'campaign_type' => $resource->getCampaignType(),
            'post' => $resource->getPost(),
            'ticket_id' => $resource->getTicket()?->getId(),
            'copy' => $resource->getCopy(),
            'status' => $resource->getStatus()->getValue(),
            'client_id' => $resource->getClient()->getId(),
            'channels' => $resource->getChannels(),
            'notes' => $resource->getNotes(),
            'post_date' => $resource->getPostDate(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $socialMedia;
    }
}
