<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Factories;

use App\Repositories\Interfaces\SocialMediaAttachmentRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaAttachmentFactoryInterface;
use App\Services\SocialMedia\Resources\CreateAttachmentResource;

final class SocialMediaAttachmentFactory implements SocialMediaAttachmentFactoryInterface
{
    private SocialMediaAttachmentRepositoryInterface $socialMediaAttachmentRepository;

    public function __construct(SocialMediaAttachmentRepositoryInterface $socialMediaAttachmentRepository) {
        $this->socialMediaAttachmentRepository = $socialMediaAttachmentRepository;
    }

    public function make(CreateAttachmentResource $resource): void
    {
        $this->socialMediaAttachmentRepository->create([
            'social_media_id' => $resource->getSocialMedia()->getId(),
            'file_id' => $resource->getFile()->getId(),
        ]);
    }
}
